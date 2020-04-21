<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_must_be_authenticated_to_add_a_avatar()
    {
        $this->json('POST', '/api/users/1/avatar')
            ->assertStatus(401);
    }

    /** @test */
    public function a_valid_image_must_be_provided()
    {
        $this->signIn();

        $this->json('POST', '/api/users/1/avatar', [
            'avatar' => 'not-valid-image'
        ])->assertStatus(422);
    }

    /** @test */
    public function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('avatar');

        $this->json('POST', 'api/users/'. auth()->id() .'/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals(asset('avatars/' . $file->hashName()), auth()->user()->avatar_path);

        Storage::disk('avatar')->assertExists('avatars/'.$file->hashName());
    }
}
