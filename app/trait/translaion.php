<?php

namespace App\trait;

trait translaion
{
    public function translate( $en_name, $ar_name ){
        // Add to file translation
        $filePath = base_path("lang\\ar.json"); // Get Path
        if (file_exists($filePath)) {
            $lang = json_decode(file_get_contents($filePath), true);  // Get old data
            $lang[$en_name] = $ar_name; // New data
            $jsonTranslations = json_encode($lang, JSON_UNESCAPED_UNICODE ); // Convert new data to json
            file_put_contents($filePath, $jsonTranslations); // Put data at file json
        }
    }
}
