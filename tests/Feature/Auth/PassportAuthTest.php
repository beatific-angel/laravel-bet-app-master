<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PassportAuthTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function we_can_register_user()
    {
        $passportClient = $this->createPassportPasswordClient();

        $this->apiPost(route('api.register'), [
                'username' => 'cauvin.ju@gmail.com',
                'password' => '000000',
                'client_id' => $passportClient->id,
                'client_secret' => $passportClient->secret,
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['token_type', 'expires_in', 'access_token', 'refresh_token']);

        $this->assertNotEmpty(User::where('email', 'cauvin.ju@gmail.com')->first());
    }

    /** @test */
    public function we_cannot_register_an_already_existing_user()
    {
        $user = factory(User::class)->create(['password' => '000000']);

        $passportClient = $this->createPassportPasswordClient();

        $this->apiPost(route('api.register'), [
                'username' => $user->email,
                'password' => '000000',
                'client_id' => $passportClient->id,
                'client_secret' => $passportClient->secret,
            ])
            ->assertJsonValidationErrors(['username']);
    }

    /** @test */
    public function we_can_login_as_an_user()
    {
        $user = factory(User::class)->create(['password' => '000000']);

        $passportClient = $this->createPassportPasswordClient();

        $this->apiPost(route('passport.token'), [
                'grant_type' => 'password',
                'client_id' => $passportClient->id,
                'client_secret' => $passportClient->secret,
                'username' => $user->email,
                'password' => '000000',
            ])
            ->assertSuccessful()
            ->assertJsonStructure(['token_type', 'expires_in', 'access_token', 'refresh_token']);
    }

    /**
     * @return mixed
     */
    private function createPassportPasswordClient()
    {
        return Passport::client()->create([
            'user_id' => null,
            'name' => 'password_grant_token',
            'secret' => Str::random(40),
            'redirect' => env('APP_URL'),
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);
    }
}
