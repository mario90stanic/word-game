<?php declare(strict_types=1);

namespace App\Models;

use App\Interfaces\PlayerInterface;
use App\Abstraction\User;

class Player extends User implements PlayerInterface
{
    /**
     * @param $userID
     * @return int
     */
    public function getPlayersPoints($userID): int
    {
        $sql = [
            'sql' =>'SELECT SUM(points) AS points FROM words WHERE user_id = :userID',
            'params' => ['userID' => $userID]
        ];

        return (int)$this->database->get($sql)->points;
    }
}