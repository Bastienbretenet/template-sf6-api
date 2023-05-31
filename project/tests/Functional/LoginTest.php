<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class LoginTest extends ApiTestCase
{
    public function testLogin(): void
    {
        $response = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'email' => 'bastienbretenet@gmail.com',
            'password' => 'password',
        ]]);

        $this->assertResponseIsSuccessful();
    }

    public function testLoginFailEmail(): void
    {
        $response = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'email' => 'fail_email@gmail.com',
            'password' => 'password',
        ]]);

        $this->assertResponseStatusCodeSame(401, 'Invalid credentials.');
    }

    public function testLoginFailPassword(): void
    {
        $response = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'email' => 'bastienbretenet@gmail.com',
            'password' => 'fail_password',
        ]]);

        $this->assertResponseStatusCodeSame(401, 'Invalid credentials.');
    }
}
