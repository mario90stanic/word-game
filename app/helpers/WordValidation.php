<?php declare(strict_types=1);

namespace App\Helpers;

use App\Core\App;
use App\Interfaces\DictionaryInterface;
use App\Models\Word;
use Exception;

class WordValidation
{
    private DictionaryInterface $dictionary;
    private Word $wordObj;
    private mixed $database;

    /**
     * @param DictionaryInterface $dictionary
     * @param Word $wordObj
     * @param App $app
     * @throws Exception
     */
    public function __construct(DictionaryInterface $dictionary, Word $wordObj, App $app)
    {
        $this->dictionary = $dictionary;
        $this->wordObj = $wordObj;
        $this->database = $app::get('database');
    }

    /**
     * @throws Exception
     */
    public function validate(string $word, int $userID): array
    {
       if ($this->checkDailyEnteredWord($userID)) {
           $_SESSION['message'] = 'You have already entered the word for a day.';
           redirect('');
       }

        if ($word === '') {
            $_SESSION['message'] = 'You need to enter a word.';
            redirect('');
        }

        if (!$this->checkDictionary($word)) {
            $_SESSION['message'] = 'The word is not in the dictionary.';
            redirect('');
        }

        if (!$this->isUniqueWord($word)) {
            $_SESSION['message'] ='You already used this word.';
            redirect('');
        }

        return [
            'status' => true,
            'message' => 'The word is valid.'
        ];
    }

    /**
     * @param int $userID
     * @return bool
     */
    public function checkDailyEnteredWord(int $userID): bool
    {
        $sql = [
            'sql' => 'SELECT * FROM words WHERE user_id = :userID AND created_at >= NOW() - INTERVAL 1 DAY ORDER BY created_at DESC LIMIT 1',
            'params' => [
                'userID' => $userID
            ]
        ];

        return (bool) $this->database->get($sql);
    }

    /**
     * @param string $word
     * @return mixed
     */
    private function checkDictionary(string $word): mixed
    {
        return $this->dictionary->checkTheWord($word);
    }

    /**
     * @param $word
     * @return bool
     */
    private function isUniqueWord($word): bool
    {
        if (!$this->wordObj->getWord($word)) {
            return true;
        }

        return false;
    }
}