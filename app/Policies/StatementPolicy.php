<?php

namespace App\Policies;

use App\Models\Statement;
use App\Models\User;

class StatementPolicy
{
    /**
    * Perform pre-authorization checks.
    */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function get(User $user, Statement $statement): bool
    {
        return $user->id === $statement->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Statement $statement): bool
    {
        return $user->id === $statement->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function remove(User $user, Statement $statement): bool
    {
        return $user->id === $statement->user_id;
    }
}
