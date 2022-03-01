<?php

namespace App\Helpers;

use App\Interfaces\Dictionary;

class EnglishDictionary implements Dictionary
{
    private $endPoint = 'https://api.dictionaryapi.dev/api/v2/entries/en/';

    public static function checkTheWord($word): bool
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, (new self)->endPoint . $word);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $content = json_decode(curl_exec($curl));

        if (is_object($content) && $content->title === 'No Definitions Found') {
            return false;
        }

        return true;
    }
}