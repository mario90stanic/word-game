<?php declare(strict_types=1);

namespace App\Abstraction;

use App\Core\App;
use App\Helpers\WordValidation;
use Exception;

abstract class User
{
    protected mixed $database;
    protected WordValidation $wordValidation;

    /**
     * @param App $app
     * @param WordValidation $wordValidation
     */
    public function __construct(App $app, WordValidation $wordValidation)
    {
        $this->wordValidation = $wordValidation;

        try {
            $this->database = $app::get('database');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    /**
     * @param $mail
     * @return mixed
     * @throws Exception
     */
    public function getEmail($email): mixed
    {
        $sql = [
            'sql' => 'SELECT email FROM users WHERE email = :email LIMIT 1',
            'params' => ['email' => $email]
        ];

        return $this->database->get($sql);
    }

    /**
     * @param $data
     * @return void
     */
    public function getUser($data)
    {
        $sql = [
            'sql' =>'SELECT id, first_name, last_name, password FROM users WHERE email = :email LIMIT 1',
            'params' => ['email' => $data['email']]
        ];
        $user = $this->database->get($sql);

        if (password_verify($data['password'], $user->password)) {
            $_SESSION['user'] = [
                'id' => (int) $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'points' => $this->getPlayersPoints($user->id),
                'daily_word' => $this->wordValidation->checkDailyEnteredWord((int)$user->id)
            ];

            redirect('');
        }

        redirect('login');
    }

    /**
     * @param $data
     * @return bool
     */
    public function create($data): bool
    {
        unset($data['repeat_password']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        return $this->database->insert('users', $data);
    }
}