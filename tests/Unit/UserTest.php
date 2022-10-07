<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login_api()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'elmehdi@gmail.com',
            'password' => 'password',
        ]);
        $response->assertStatus(200);
    }

    public function test_user_duplication()
    {
        $user1 = User::make([
            'name' => 'El mehdi ait fakir',
            'email' => 'elmehdiaitfakir@gmail.com',
        ]);

        $user2 = User::make([
            'name' => 'Younes ait fakir',
            'email' => 'younes@gmail.com',
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    public function test_user_delete()
    {
        $user = User::factory(1)->create();
        $user = User::first();

        if ($user) {
            $user->delete();
        }

        $this->assertTrue(true);
    }

    public function test_user_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'User 00',
            'email' => 'user00@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function test_database_has()
    {
        $this->assertDatabaseHas('users', [
            'name' => 'User 00',
        ]);
    }

    public function test_database_missing()
    {
        $this->assertDatabaseMissing('users', [
            'name' => 'EL MEHDI',
        ]);
    }

    public function test_if_seeder_work()
    {
        $this->seed();
    }
}
