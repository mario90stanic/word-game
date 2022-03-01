<?php

namespace App\Controllers;

use App\Core\App;
use App\Helpers\EnglishDictionary;
use App\Helpers\WordValidation;
use App\Models\User;
use App\Models\Word;
use Exception;

class WordsController
{
    private $word;

    public function __construct()
    {
        $this->word = $_POST['word'];
    }

    /**
     * @return void
     */
    public function store()
    {
        try {
            $word = new Word(App::get('config'), App::get('database'), $this->word);
            $validator = new WordValidation(new EnglishDictionary, $this->word, App::get('database'));
            $validator->validate($word);

            $word->insert();

            $_SESSION['user']['points'] = (new User)->getUserPoints($_SESSION['user']['id']);
            redirect('');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}