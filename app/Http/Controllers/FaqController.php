<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Http\Controllers\Base\BaseController;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class FaqController extends BaseController implements HasMiddleware
{
    protected $validationRules;

    public static function middleware(): array
    {
        $guard = [PermissionsEnum::MANAGE_FAQS->value, RolesEnum::SUPERADMIN->value, RolesEnum::ROOT->value];

        return [
            new Middleware(
                'role_or_permission:' . implode('|', $guard),
                except: ['index']
            ),
        ];
    }

    public function __construct(Request $request)
    {
        $required = $request->method() === 'POST' ? 'required' : 'sometimes';

        $this->validationRules = [
            'question' => $required . '|string|max:255',
            'answer' => $required . '|string',
            'category' => 'nullable|string',
            'is_active' => 'sometimes|boolean'
        ];
    }

    public function index()
    {
        $limit = request()->get('limit', 100);
        $data = FAQ::limit($limit)->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules);

        FAQ::create($request->all());

        return back(303)->with('success', 'FAQ ajoutée avec succès');
    }

    public function update(Request $request, FAQ $faq)
    {
        $request->validate($this->validationRules);

        $faq->update($request->all());

        return back(303)->with('success', 'FAQ mise à jour avec succès');
    }

    public function destroy(FAQ $faq)
    {
        $faq->delete();
        return back(303)->with('success', 'FAQ supprimé avec succès');
    }
}
