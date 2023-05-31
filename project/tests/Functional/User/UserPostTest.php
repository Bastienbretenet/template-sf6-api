<?php

namespace App\Tests\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UserPostTest extends ApiTestCase
{
    public function testCreateUser(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'bastien@test.com',
            'password' => 'password',
        ]]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserAlreadyExist(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'bastien@test.com',
            'password' => 'password',
        ]]);

        $this->assertResponseStatusCodeSame(422, 'This value is already used.');
    }

    public function testCreateUserEmptyEmail(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => '',
            'password' => 'password',
        ]]);

        $this->assertResponseStatusCodeSame(422, 'This value should not be blank.');
    }

    public function testCreateUserBadEmail(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'bad_email',
            'password' => 'password',
        ]]);

        $this->assertResponseStatusCodeSame(422, 'This value is not a valid email address.');
    }

    public function testCreateUserEmptyPassword(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'fail_email',
            'password' => '',
        ]]);

        $this->assertResponseStatusCodeSame(422, 'This value should not be blank.');
    }
}
