<?php

namespace App\app\helpers;

use App\Models\User;

class UserValidation
{
    private $data;
    private $user;
    private $required = [
        'first_name',
        'last_name',
        'email',
        'password',
        'repeat_password',
    ];

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->user = new User();
        $this->data = $data;
    }

    public function validate()
    {
        $fields = $this->requiredFields();

        if (!empty($fields['missing'])) {
            $_SESSION['message'] = 'There fields are required: ' . implode(', ', $fields['missing']);
            $_SESSION['old_values'] = $fields['old_values'];
            return true;
        }

        if (!$this->isEmailFormat()) {
            $_SESSION['message'] = 'The format of the email is invalid.';
            $_SESSION['old_values'] = $fields['old_values'];
            return true;
        }

        if (!$this->isUniqueEmail()) {
            $_SESSION['message'] = 'Somebody already registered with this email.';
            $_SESSION['old_values'] = $fields['old_values'];
            return true;
        }

        if (!$this->confirmPassword()) {
            $_SESSION['message'] = 'Password needs to match with confirm password field.';
            $_SESSION['old_values'] = $fields['old_values'];
            return true;
        }
    }

    /**
     * @return array
     */
    private function requiredFields(): array
    {
        $missing = [];
        $oldValues = [];

        foreach ($this->required as $item) {
            if ($this->data[$item] == '') {
                $missing[] = ucfirst(str_replace('_', ' ', $item));
            } elseif ($item != 'password' && $item != 'repeat_password') {
                $oldValues[$item] = $this->data[$item];
            }
        }

        return [
            'missing' => $missing,
            'old_values' => $oldValues
        ];
    }

    /**
     * @return false|void
     */
    private function isEmailFormat()
    {
        if (filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function isUniqueEmail(): bool
    {
        if (!$this->user->getEmail($this->data['email'])) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function confirmPassword(): bool
    {
        if ($this->data['password'] !== $this->data['repeat_password']) {
            return false;
        }

        return true;
    }
}