<?php

namespace App\Tests\User;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;

class UserGetTest extends ApiTestCase
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

    public function testGetUsersCollectionWithAdmin(): void
    {
        $response = $this->createClientWithCredentials()->request('GET', '/api/users');
        $this->assertResponseIsSuccessful();
    }

    public function testGetUserWithAdmin(): void
    {
        $response = $this->createClientWithCredentials()->request('GET', '/api/users/2');
        $this->assertResponseIsSuccessful();
    }

    public function testGetUsersCollectionWithUser(): void
    {
        $token = $this->getToken([
            'email' => 'bastien@agenceatom.com',
            'password' => 'password',
        ]);
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/users');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetUserWithUser(): void
    {
        $token = $this->getToken([
            'email' => 'bastien@agenceatom.com',
            'password' => 'password',
        ]);
        $response = $this->createClientWithCredentials($token)->request('GET', '/api/users/1');
        $this->assertResponseStatusCodeSame(403);
    }
}
