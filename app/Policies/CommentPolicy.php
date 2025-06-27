<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
//    /**
//     * Create a new policy instance.
//     */
//    public function __construct()
//    {
//        //
//    }

    public function update(Comment $comment, User $user): bool
    {
        return ($user->id === $comment->user->id) || $user->isAdmin;
    }
    public function delete(Comment $comment, User $user): bool
    {
        return ($user->id === $comment->user->id) || $user->isAdmin;
    }
}
