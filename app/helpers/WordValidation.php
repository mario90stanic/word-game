<?php

namespace App\Helpers;

use App\Core\App;
use App\interfaces\Dictionary;
use App\Models\Word;

class WordValidation
{
    private $word;
    private $dictionary;
    private $database;

    /**
     * @param Dictionary $dictionary
     * @param $word
     */
    public function __construct(Dictionary $dictionary, $word, $database)
    {
        $this->word = $word;
        $this->dictionary = $dictionary;
        $this->database = $database;
    }

    /**
     * @throws \Exception
     */
    public function validate(Word $word)
    {
        if (!$this->checkDictionary($word)) {
            $_SESSION['message'] = 'The word is not in the dictionary';
            return redirect('');
        }

        if (!$this->isUniqueWord($word)) {
            $_SESSION['message'] ='You already used this word.';
            return redirect('');
        }

        return [
            'status' => true,
            'message' => 'The word is valid.'
        ];
    }

    /**
     * @return mixed
     */
    private function checkDictionary()
    {
        return $this->dictionary->checkTheWord($this->word);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function isUniqueWord(Word $word)
    {
        if (!$word->getWord()) {
            return true;
        }

        return false;
    }
}