<?php

namespace App\Policies;

use App\Models\FavoriteMovie;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FavoriteMoviePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FavoriteMovie $favoriteMovie): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FavoriteMovie $favoriteMovie): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FavoriteMovie $favoriteMovie): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FavoriteMovie $favoriteMovie): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FavoriteMovie $favoriteMovie): bool
    {
        return false;
    }
}
