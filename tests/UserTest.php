<?php declare(strict_types=1);

use App\app\helpers\UserValidation;
use App\Models\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    /**
     * @test
     */
    public function checkUserValidation()
    {
        $mockRepo = $this->createMock(User::class);
        $getEmail = $mockRepo->getEmail('test@test.com');

        $mockRepo->method('getEmail')->willReturn('test@test.com');


        $user = [
            'first_name' => 'Mario',
            'last_name' => 'Stanic',
            'email' => 'mario90stanic@gmail.com',
            'password' => '123456',
            'repeat_password' => '123456',
        ];
//
        $validation = new UserValidation($user);
        $this->assertTrue(true);
//
        $this->assertTrue($validation->validate());
    }
}