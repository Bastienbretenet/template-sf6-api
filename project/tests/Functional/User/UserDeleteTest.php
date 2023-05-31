<?php

namespace App\Tests\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;

class UserDeleteTest extends ApiTestCase
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

    public function testCreateUserToDeleteWithAdmin(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'bastienToDelete1@test.com',
            'password' => 'password',
        ]]);

        $data = $response->toArray();
        $id = $data['id'];

        $response = $this->createClientWithCredentials()->request('DELETE', '/api/users/'.$id);
        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserToDeleteWithSelfUser(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'bastienToDelete2@test.com',
            'password' => 'password',
        ]]);

        $data = $response->toArray();
        $id = $data['id'];

        $token = $this->getToken([
            'email' => 'bastienToDelete2@test.com',
            'password' => 'password',
        ]);

        $response = $this->createClientWithCredentials($token)->request('DELETE', '/api/users/'.$id);
        $this->assertResponseStatusCodeSame(403);
    }

    public function testCreateUserToDeleteWithOtherUser(): void
    {
        $response = static::createClient()->request('POST', '/api/users', ['json' => [
            'email' => 'bastienToDelete3@test.com',
            'password' => 'password',
        ]]);

        $data = $response->toArray();
        $id = $data['id'];

        $token = $this->getToken([
            'email' => 'bastien@agenceatom.com',
            'password' => 'password',
        ]);

        $response = $this->createClientWithCredentials($token)->request('DELETE', '/api/users/'.$id);
        $this->assertResponseStatusCodeSame(403);
    }
}
