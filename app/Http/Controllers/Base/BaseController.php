<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use App\Traits\GetRecordsTrait;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseController extends Controller
{
    use GetRecordsTrait;

    protected function paginate($items, $perPage = 20, $page = null, $options = [])
    {
        $options = count($options) ? $options : ['path' => request()->fullUrl()];

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    protected function storeImage(Request $request, $folder = 'images')
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            return $file->store($folder, 'public');
        }

        return null;
    }

    protected function deleteImage($path)
    {
        try {
            Storage::delete($path);
        } catch (\Throwable $th) {
            //throw $th;
            report($th);
        }
    }

    protected function validateCaptcha(Request $request): array
    {
        // Validation des entrées + reCAPTCHA
        $validator = Validator::make($request->all(), [
            'poll_option_id' => 'required|exists:poll_options,id',
            'g-recaptcha-response' => ['required', 'captcha'],
        ]);

        if ($validator->fails()) {
            return ['message' => 'Validation échouée.', 'code' => 422];
        }

        return ['message' => 'Validation reussie.', 'code' => 200];
    }
}
