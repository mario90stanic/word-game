<?php declare(strict_types=1);

namespace App\Helpers;

use App\Interfaces\PlayerInterface;
use Exception;

class UserValidation
{
    private array $data;
    private PlayerInterface $user;
    private array $missing = [];
    private array $oldValues = [];
    private array $required = [
        'first_name',
        'last_name',
        'email',
        'password',
        'repeat_password',
    ];

    /**
     * @param $data
     */
    public function __construct(PlayerInterface $user)
    {
        $this->user = $user;
        $this->data = $_POST;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function validate(): bool
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

        return false;
    }

    /**
     * @return array
     */
    private function requiredFields(): array
    {
        foreach ($this->required as $item) {
            $this->checkValidateData($item);
        }

        return [
            'missing' => $this->missing,
            'old_values' => $this->oldValues
        ];
    }

    /**
     * @return bool
     */
    private function isEmailFormat(): bool
    {
        if (filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     * @throws Exception
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

    private function checkValidateData($item)
    {
        if ($this->data[$item] == '') {
            $this->missing[] = ucfirst(str_replace('_', ' ', $item));
        } elseif ($item != 'password' && $item != 'repeat_password') {
            $this->oldValues[$item] = $this->data[$item];
        }
    }
}