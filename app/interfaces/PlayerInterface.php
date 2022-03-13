<?php declare(strict_types=1);

namespace App\Interfaces;

interface PlayerInterface
{
    public function getPlayersPoints($userID): int;
    public function getEmail($email): mixed;
    public function create($data);
}