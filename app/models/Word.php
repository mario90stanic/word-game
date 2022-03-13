<?php declare(strict_types=1);

namespace App\Models;

use App\Core\App;
use Exception;

class Word
{
    private $config;
    private $database;

    /**
     * @throws Exception
     */
    public function __construct(App $app)
    {
        $this->config = $app::get('config');
        $this->database = $app::get('database');
    }
    /**
     * @return void
     */
    public function insert($word)
    {
        try {
            $points = $this->calculatePoints($word);

            return $this->database->insert('words', [
                'word' => $word,
                'user_id' => $_SESSION['user']['id'],
                'points' => $points['total'],
                'is_palindrome' => $points['status']
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public function getWord($word)
    {
        $sql = [
            'sql' => 'SELECT id FROM words WHERE word = :word AND user_id = :user_id',
            'params' => [
                'word' => $word,
                'user_id' => $_SESSION['user']['id']
                ]
            ];

        return $this->database->get($sql);
    }

    /**
     * @param $word
     * @return bool
     */
    private function isPalindrome($word): bool
    {
        return $word == strrev($word);
    }

    /**
     * @param $word
     * @return bool
     */
    private function isAlmostPalindrome($word): bool
    {
        $reverse = strrev($word);
        $length = strlen($word);
        $sim = similar_text($word, $reverse);

        if ($length - 1 == $sim) {
            return true;
        }

        return false;
    }

    /**
     * @param $word
     * @return array
     */
    private function calculatePalindromePoints($word): array
    {
        if ($this->isPalindrome($word)) {
            return [
                'points' => (int)$this->config['palindrome_points'],
                'status' => 1
            ];
        } else if ($this->isAlmostPalindrome($word)) {
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
    public function calculatePoints($word): array
    {
        $palPoints = $this->calculatePalindromePoints($word);
        $wordSplit = str_split($word);
        $total = count(array_unique($wordSplit));
        $total += $palPoints['points'];

        return [
            'total' => $total,
            'status' => $palPoints['status']
        ];
    }
}