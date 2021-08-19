<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserAvatarTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_user_can_upload_an_avatar()
    {
        Storage::fake();

        $user = factory(User::class)->create();

        $this->apiActingAs($user)
            ->apiPost(route('api.users.me.avatar.store'), [
                'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            ])
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'avatar' => Storage::url('avatars/'. $user->id .'.jpg')
                ]
            ]);

        Storage::assertExists('avatars/'. $user->id .'.jpg');
    }
}
