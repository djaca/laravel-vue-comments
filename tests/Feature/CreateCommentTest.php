<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_new_comment()
    {
        $user = factory(User::class)->create();

        $data = [
            'user_id' => $user->id,
            'page_id' => 1,
            'body' => 'Some comment'
        ];

        $this->actingAs($user)->post(route('comments'), $data);

        $this->assertDatabaseHas('comments', $data);
    }
}
