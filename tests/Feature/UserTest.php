<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_user_can_get_his_informations()
    {
        $user = factory(User::class)->create();

        $this->apiActingAs($user)
            ->apiGet(route('api.users.me'))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'avatar' => '',
                ]
            ]);
    }

    /** @test */
    public function an_user_can_update_his_name()
    {
        $user = factory(User::class)->create(['name' => 'Toto']);

        $this->apiActingAs($user)
            ->apiPut(route('api.users.me.update'), ['name' => 'New name'])
            ->assertSuccessful()
            ->assertJson(['data' => ['name' => 'New name']]);

        $this->assertEquals('New name', $user->refresh()->name);
    }

    /** @test */
    public function an_user_can_update_his_email()
    {
        $user = factory(User::class)->create(['email' => 'test@user.com']);

        $this->apiActingAs($user)
            ->apiPut(route('api.users.me.update'), ['email' => 'toto@test.com'])
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'email' => 'toto@test.com',
                    'name' => $user->name
                ]
            ]);

        $this->assertCount(0, User::where('email', 'test@user.com')->get());
        $this->assertCount(1, User::where('email', 'toto@test.com')->get());
    }

    /** @test */
    public function email_must_be_valid()
    {
        $this->apiActingAs()
            ->apiPut(route('api.users.me.update'), [
                'email' => 'WRONG_EMAIL',
            ])
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function an_user_can_update_his_password()
    {
        $user = factory(User::class)->create(['password' => '000000']);

        $this->apiActingAs($user)
            ->apiPut(route('api.users.me.update'), [
                'password' => '123456',
                'password_confirm' => '123456'
            ])
            ->assertSuccessful();

        $user->refresh();

        $this->assertTrue(Hash::check('123456', $user->getAttribute('password')));
    }

    /** @test */
    public function password_confirmation_is_required_in_order_to_change_password()
    {
        $this->apiActingAs()
            ->apiPut(route('api.users.me.update'), [
                'password' => '123456',
            ])
            ->assertJsonValidationErrors(['password_confirm']);
    }
}
