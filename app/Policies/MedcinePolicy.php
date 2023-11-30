<?php

namespace App\Policies;

use App\Models\Medcine;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedcinePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
       return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Medcine $medcine)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->isStoreOwner;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Medcine $medcine): bool
    {
        return $user->isStoreOwner;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Medcine $medcine): bool
    {
        return $user->isStoreOwner;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Medcine $medcine): bool
    {
        return $user->id === $medcine->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Medcine $medcine): bool
    {
        return $user->id === $medcine->user_id;
    }
}
