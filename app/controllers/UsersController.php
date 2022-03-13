<?php declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\UserValidation;
use App\Interfaces\PlayerInterface;

class UsersController
{
    private UserValidation $validator;
    private PlayerInterface $user;
    private array $data;

    public function __construct(UserValidation $validator, PlayerInterface $user)
    {
        $this->validator = $validator;
        $this->data = $_POST;
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function register(): mixed
    {
        return view('registration');
    }

    public function loginView()
    {
        return view('login');
    }

    /**
     * @return mixed
     */
    public function login(): mixed
    {
        $this->user->getUser($this->data);

        return view('login');
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function store()
    {
        if($this->validator->validate()) {
            redirect('registration');
        }

        return $this->user->create($this->data);

       // redirect('');
    }

    public function logout()
    {
        unset($_SESSION['user']);

        redirect('login');
    }
}
