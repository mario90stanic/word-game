<?php

namespace App\Models;

use Exception;

class Word
{
    private $word = '';
    private $config;
    private $database;

    public function __construct(array $config, $database = null, string $word)
    {
        $this->config = $config;
        $this->word = $word;
        $this->database = $database;
    }
    /**
     * @return void
     */
    public function insert()
    {
        try {
            $points = $this->calculatePoints();

            return $this->database->insert('words', [
                'word' => $this->word,
                'user_id' => $_SESSION['user']['id'],
                'points' => $points['total'],
                'is_palindrome' => $points['status']
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getWord()
    {
        // todo: prepare statement
        return $this->database->get('SELECT id FROM words WHERE word = "' . $this->word . '" AND user_id = ' . $_SESSION['user']['id']);
    }

    /**
     * @param $word
     * @return bool
     */
    private function isPalindrome()
    {
        return $this->word == strrev($this->word);
    }

    /**
     * @return bool
     */
    private function isAlmostPalindrome()
    {
        $reverse = strrev($this->word);
        $length = strlen($this->word);
        $sim = similar_text($this->word, $reverse);

        if ($length - 1 == $sim) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function calculatePalindromePoints()
    {
        if ($this->isPalindrome()) {
            return [
                'points' => (int)$this->config['palindrome_points'],
                'status' => 1
            ];
        } else if ($this->isAlmostPalindrome()) {
            return [
                'points' => (int)$this->config['almost_palindrome_points'],
                'status' => 2
            ];
        }

        return [
            'points' => 0,
            'status' => 0
        ];
    }

    /**
     * @param $word
     * @return array
     * @throws Exception
     */
    public function calculatePoints()
    {
        $palPoints = $this->calculatePalindromePoints();
        $wordSplit = str_split($this->word);
        $total = count(array_unique($wordSplit));
        $total += $palPoints['points'];

        return [
            'total' => $total,
            'status' => $palPoints['status']
        ];
    }
}