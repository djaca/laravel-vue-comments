<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CommentVote extends Pivot
{
    protected $fillable = ['comment_id', 'user_id', 'type'];

    protected $table = 'comment_vote';

    public $timestamps = false;
}
