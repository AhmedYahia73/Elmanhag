<?php

namespace App\Http\Controllers\api\v1\lang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function languages_api(){
        $translation_link = resource_path("lang"); // Get Path file

        return response()->json([
            'translation_link' => $translation_link,
        ]);
    }
}
