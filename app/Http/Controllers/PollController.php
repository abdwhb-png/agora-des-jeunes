<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollVote;
use App\Models\PollOption;
use App\Models\PollResult;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PollCollection;
use Illuminate\Database\Query\Builder;
use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\PollRequest;

class PollController extends BaseController
{
    public function index(): JsonResponse
    {
        $limit = request()->get('limit', 100);
        $data = Poll::limit($limit)->get();
        return response()->json($data);
    }

    public function show(Poll $poll): JsonResponse
    {
        if (!$poll) {
            return response()->json(['error' => 'Sondage introuvable'], 404);
        }

        // Charger les options et compter les votes en une seule requête
        $poll->loadCount('votes as total_votes');

        // Mapper les options avec le nombre de votes
        $results = $poll->options->map(function ($option) use ($poll) {
            return [
                'option' => $option->option_text,
                'votes' => $poll->votes()->where('poll_option_id', $option->id)->count(),
            ];
        });

        return response()->json([
            'poll' => $poll,
            'total_votes' => $poll->total_votes,
            'results' => $results,
        ]);
    }


    public function store(PollRequest $request)
    {
        $request->validated();

        $poll = Poll::create($request->only(['title', 'description', 'is_public', 'published', 'show_options', 'start_at', 'end_at']));

        foreach ($request->options as $option) {
            PollOption::create([
                'poll_id' => $poll->id,
                'option_text' => $option['option_text'],
            ]);
        }

        return back()->with('success', 'Sondage créé avec succès !');
    }


    public function update(PollRequest $request, Poll $poll)
    {
        $request->validated();

        $poll->update($request->all());

        if ($request->options) {
            foreach ($request->options as $option) {
                if ($pollOption = PollOption::find($option['id'])) {
                    $pollOption->update([
                        'option_text' => $option['option_text'],
                    ]);
                }
            }
        }

        return back()->with('success', 'Sondage mis à jour avec succès !');
    }


    public function vote(Request $request, Poll $poll)
    {
        $captchaValidation = $this->validateCaptcha($request);

        if ($captchaValidation['code'] != 200) {
            return response()->json(['message' => $captchaValidation['message']], $captchaValidation['code']);
        }

        $request->validate([
            'poll_option_id' => 'sometimes|exists:poll_options,id',
            'answer' => 'sometimes|string',
        ]);

        // Vérifier si l'utilisateur a déjà voté (authentifié ou anonyme)
        $existingVote = $poll->votes()->where(function ($query) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                $query->where('ip_address', request()->ip())
                    ->orWhere('session_id', session()->getId());
            }
        })
            ->exists();

        if ($existingVote) {
            return response()->json(['message' => 'Vous avez déjà voté.'], 403);
        }

        // Enregistrement du vote
        $poll->vote()->create([
            'poll_option_id' => $request->poll_option_id ?? null,
            'answer' => $request->answer ?? null,
            'user_id' => Auth::id(),
            'ip_address' => Auth::check() ? null : request()->ip(),
            'session_id' => Auth::check() ? null : session()->getId(),
        ]);

        return response()->json(['message' => 'Vote enregistré avec succès.']);
    }


    public function stats(): JsonResponse
    {
        $results = Poll::all()->map(function ($poll) {
            return [
                'poll' => $poll,
                'total_votes' => $poll->votes()->count(),
                'anonymous_votes' => $poll->votes()->whereNull('user_id')->count(),
                'authenticated_votes' => $poll->votes()->whereNotNull('user_id')->count(),
                'options' => $poll->options->map(function ($option) use ($poll) {
                    return [
                        'option' => $option->with('votes'),
                        'total_votes' => $poll->votes()->where('poll_option_id', $option->id)->count(),
                    ];
                }),
            ];
        });

        return response()->json([
            'results' => $results,
        ]);
    }
}
