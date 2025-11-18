<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_register_name_required_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'bbb@ccc.com',
            'password' => 'test12345',
            'password_confirmation' => 'test12345',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);

        //$response->assertRedirect('/register');
    }

    public function test_register_email_required_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->from('/register')->post('/register', [
            'name' => 'aaa',
            'email' => '',
            'password' => 'test12345',
            'password_confirmation' => 'test12345',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_register_password_required_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->from('/register')->post('/register', [
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => '',
            'password_confirmation' => 'test12345',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function test_register_password_min_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->from('/register')->post('/register', [
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test',
            'password_confirmation' => 'test',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }

    public function test_register_password_confirmed_validation()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->from('/register')->post('/register', [
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test1234',
            'password_confirmation' => 'test12345',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません',
        ]);
    }

    public function test_register_success_redirects_to_profile()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register', [
            'name' => 'aaa',
            'email' => 'bbb@ccc.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ]);

        $response->assertRedirect('/mypage/profile');

        $this->assertDatabaseHas('users', [
            'email' => 'bbb@ccc.com'
        ]);
    }
}
