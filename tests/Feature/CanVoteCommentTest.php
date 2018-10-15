<?php

namespace Tests\Feature;

use App\Comment;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanVoteCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_vote_up_a_comment()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->postJson(route('comments.vote', $comment->id), [
            'user_id' => $user->id,
            'type' => 'up'
        ]);

        $this->assertEquals(1, $comment->fresh()->votes);

        $this->assertDatabaseHas('comment_vote', [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => 'up'
        ]);
    }

    /** @test */
    public function user_can_vote_down_a_comment()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create(['votes' => 3]);

        $this->postJson(route('comments.vote', $comment->id), [
            'user_id' => $user->id,
            'type' => 'down'
        ]);

        $this->assertEquals(2, $comment->fresh()->votes);

        $this->assertDatabaseHas('comment_vote', [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
            'type' => 'down'
        ]);
    }

    /** @test */
    public function user_cannot_vote_same_comment()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->postJson(route('comments.vote', $comment->id), [
            'user_id' => $user->id,
            'type' => 'up'
        ]);

        $this->assertEquals(1, $comment->fresh()->votes);

        $this->postJson(route('comments.vote', $comment->id), [
            'user_id' => $user->id,
            'type' => 'up'
        ]);

        $this->assertEquals(1, $comment->fresh()->votes);
    }
}
