<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['reply_id', 'page_id', 'user_id', 'body', 'votes'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['replies', 'user'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'name']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id', 'id')
                    ->select(['id', 'body', 'user_id', 'page_id', 'reply_id', 'created_at', 'votes'])
                    ->with('userVotes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userVotes()
    {
        return $this->belongsToMany(User::class, 'comment_vote')->withPivot(['type'])->select(['id']);
    }

    /**
     * @param $data
     */
    public function vote($data)
    {
        $this->voteComment($data['type']);

        $this->userVotes()
                ->attach($data['user_id'], ['type' => $data['type']]);
    }

    /**
     * @param $type
     */
    private function voteComment($type)
    {
        if ($type == 'up') {
            $this->increment('votes');
        } else {
            $this->decrement('votes');
        }
    }
}
