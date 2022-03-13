<?php declare(strict_types=1);

use App\Helpers\UserValidation;
use App\Controllers\UsersController;
use App\Models\Player;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    /**
     * @test
     * @dataProvider users
     */
    public function checkUserValidation($status, $data)
    {
        $mockPlayer = $this->createMock(Player::class);
        $_POST = $data;
        $validation = new UserValidation($mockPlayer);

        $this->assertEquals($status, $validation->validate());
    }

    /**
     * @test
     */
    public function createUser()
    {
        $mockPlayer = $this->createMock(Player::class);
        $mockPlayer->method('create')->willReturn(true);
        $mockValidator = $this->createMock(UserValidation::class);
        $mockValidator->method('validate')->willReturn(false);

        $userController = new UsersController($mockValidator, $mockPlayer);

        $_POST = [
            'first_name' => 'test_first_name',
            'last_name' => 'test_last_name',
            'email' => 'test@test.com',
            'password' => '123456',
            'repeat_password' => '123456',
        ];

        $this->assertTrue($userController->store());

    }

    public function users()
    {
        return [
            [
                'status' => true,
                'data' => [
                    'id' => 1,
                    'first_name' => 'test_name',
                    'last_name' => '',
                    'email' => 'test@test.com',
                    'password' => '123456',
                    'repeat_password' => '123456',
                ]
            ],
            [
                'status' => true,
                'data' => [
                    'id' => 1,
                    'first_name' => 'test_first_name',
                    'last_name' => 'test_last_name',
                    'email' => '',
                    'password' => '123456',
                    'repeat_password' => '123456',
                ]
            ],
            [
                'status' => true,
                'data' => [
                    'id' => 1,
                    'first_name' => 'test_first_name',
                    'last_name' => 'test_last_name',
                    'email' => 'test@test.com',
                    'password' => '',
                    'repeat_password' => '123456',
                ]
            ],
            [
                'status' => false,
                'data' => [
                    'id' => 1,
                    'first_name' => 'test_first_name',
                    'last_name' => 'test_last_name',
                    'email' => 'test@test.com',
                    'password' => '123456',
                    'repeat_password' => '123456',
                ]
            ]
        ];
    }
}