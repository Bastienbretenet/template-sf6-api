<?php

namespace App\Tests\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;

class UserPutTest extends ApiTestCase
{
    protected function getToken($body = []): string
    {
        $response = static::createClient()->request('POST', '/api/login_check', ['json' => $body ?: [
            'email' => 'bastienbretenet@gmail.com',
            'password' => 'password',
        ]]);
        $data = $response->toArray();

        return $data['token'];
    }

    protected function createClientWithCredentials($token = null): Client
    {
        $token = $token ?: $this->getToken();

        return static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);
    }

    public function testCreateUserToPutWithAdmin(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'bastienToPut1@test.com',
            'password' => 'password',
        ]]);

        $data = $response->toArray();
        $id = $data['id'];

        $response = $this->createClientWithCredentials()->request('PUT', '/api/users/'.$id, ['json' => [
            'email' => 'bastienToPut1@test.com',
            'password' => 'password22',
        ]]);

        $this->assertResponseIsSuccessful();

        $response = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'email' => 'bastienToPut1@test.com',
            'password' => 'password',
        ]]);

        $this->assertResponseStatusCodeSame(401);

        $response = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'email' => 'bastienToPut1@test.com',
            'password' => 'password22',
        ]]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserToPutWithSelfUser(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'bastienToPut2@test.com',
            'password' => 'password',
        ]]);

        $data = $response->toArray();
        $id = $data['id'];

        $token = $this->getToken([
            'email' => 'bastienToPut2@test.com',
            'password' => 'password',
        ]);

        $response = $this->createClientWithCredentials($token)->request('PUT', '/api/users/'.$id, ['json' => [
            'email' => 'bastienToPut2@test.com',
            'password' => 'password22',
        ]]);

        $this->assertResponseIsSuccessful();

        $response = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'email' => 'bastienToPut2@test.com',
            'password' => 'password',
        ]]);

        $this->assertResponseStatusCodeSame(401);

        $response = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'email' => 'bastienToPut2@test.com',
            'password' => 'password22',
        ]]);

        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserToPutWithOtherUser(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'bastienToPut3@test.com',
            'password' => 'password',
        ]]);

        $data = $response->toArray();
        $id = $data['id'];

        $token = $this->getToken([
            'email' => 'bastien@agenceatom.com',
            'password' => 'password',
        ]);

        $response = $this->createClientWithCredentials($token)->request('PUT', '/api/users/'.$id, ['json' => [
            'email' => 'bastienToPut3@test.com',
            'password' => 'password22',
        ]]);

        $this->assertResponseStatusCodeSame(403);

        $response = static::createClient()->request('POST', '/api/login_check', ['json' => [
            'email' => 'bastienToPut3@test.com',
            'password' => 'password',
        ]]);

        $this->assertResponseIsSuccessful();
    }
}
