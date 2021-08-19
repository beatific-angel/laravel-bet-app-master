<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param null $user
     * @return $this
     */
    public function apiActingAs($user = null)
    {
        Passport::actingAs($user ?: factory(User::class)->create());

        return $this;
    }

    /**
     * @param string $route
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function apiGet($route, $data = [], $headers = [])
    {
        return $this->json('GET', $route, $data, $headers);
    }

    /**
     * @param string $route
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function apiPost($route, $data = [], $headers = [])
    {
        return $this->json('POST', $route, $data, $headers);
    }

    /**
     * @param string $route
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function apiPut($route, $data = [], $headers = [])
    {
        return $this->json('PUT', $route, $data, $headers);
    }
}
