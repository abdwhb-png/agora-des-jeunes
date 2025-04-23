<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ModelWithFile
{

    static public function onDeleting($path = "")
    {
        if ($path) {
            try {
                Storage::delete($path);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
