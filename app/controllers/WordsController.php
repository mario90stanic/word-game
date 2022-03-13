<?php declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\WordValidation;
use App\Interfaces\PlayerInterface;
use App\Models\Word;
use Exception;

class WordsController
{
    private mixed $word;
    private PlayerInterface $user;
    private Word $wordObj;
    private WordValidation $wordValidation;

    public function __construct(
        PlayerInterface $user,
        Word $wordObj,
        WordValidation $wordValidation
    )
    {
        $this->word = $_POST['word'];
        $this->user = $user;
        $this->wordObj = $wordObj;
        $this->wordValidation = $wordValidation;
    }

    /**
     * @return void
     */
    public function store()
    {
        try {
            $this->wordValidation->validate($this->word, $_SESSION['user']['id']);
            $this->wordObj->insert($this->word);
            $_SESSION['user']['points'] = $this->user->getPlayersPoints($_SESSION['user']['id']);
            $_SESSION['user']['daily_word'] = true;

            redirect('');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}