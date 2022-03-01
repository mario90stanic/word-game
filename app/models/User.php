<?php

namespace App\Models;

use App\Core\App;

class User
{
    private $database;

    public function __construct()
    {
        $this->database = App::get('database');
    }

    /**
     * @param $mail
     * @return mixed
     * @throws \Exception
     */
    public function getEmail($email)
    {
        // todo prepare statement
        $sql = 'SELECT email FROM users WHERE email = "' . $email .'" LIMIT 1';

        return $this->database->get($sql);
    }

    public function getUser($data)
    {
        // todo prepare statement
        $sql = 'SELECT id, first_name, last_name, password FROM users WHERE email = "' . $data['email'] . '" LIMIT 1';
        $user = App::get('database')->get($sql);

        if (password_verify($data['password'], $user->password)) {
            $_SESSION['user'] = [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'points' => $this->getUserPoints($user->id)
            ];
            redirect('');
        }

        redirect('login');
    }

    public function getUserPoints($userID): int
    {
        // todo prepare statement
        $sql = 'SELECT SUM(points) AS points FROM words WHERE user_id = ' . $userID;

        return (int) App::get('database')->get($sql)->points;
    }

    /**
     * @param $data
     * @return void
     * @throws \Exception
     */
    public static function create($data)
    {
        unset($data['repeat_password']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT );

        App::get('database')->insert('users', $data);
    }
}