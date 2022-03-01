<?php

namespace App\Controllers;

use App\app\helpers\UserValidation;
use App\Models\User;

class UsersController
{
    private $validator;
    private $data;

    public function __construct()
    {
        $this->validator = new UserValidation($_POST);
        $this->data = $_POST;
    }

    /**
     * @return mixed
     */
    public function register()
    {
        return view('registration');
    }

    public function loginView()
    {
        return view('login');
    }

    public function login()
    {
        (new User)->getUser($_POST);

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

        User::create($this->data);

        redirect('');
    }

    public function logout()
    {
        unset($_SESSION['user']);

        redirect('login');
    }
}