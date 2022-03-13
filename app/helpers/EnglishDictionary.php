<?php declare(strict_types=1);

namespace App\Helpers;

use App\Interfaces\DictionaryInterface;

class EnglishDictionary implements DictionaryInterface
{
    private string $endPoint = 'https://api.dictionaryapi.dev/api/v2/entries/en/';

    public static function checkTheWord(string $word): bool
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