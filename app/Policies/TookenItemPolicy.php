<?php

namespace App\Policies;

use App\Models\TookenItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TookenItemPolicy
{
    /**
     * Determine whether the user can view any withdrawals.
     */
    public function viewAny(User $user): bool
    {
        // Only admin can view all withdrawals
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view a specific withdrawal.
     */
    public function view(User $user, TookenItem $tookenItem): bool
    {
        // Users can view their own withdrawals, admin can view all
        return $user->role === 'admin' || $user->id === $tookenItem->user_id;
    }

    /**
     * Determine whether the user can create withdrawals.
     */
    public function create(User $user): bool
    {
        // All authenticated users can create withdrawals
        return true;
    }

    /**
     * Determine whether the user can update the withdrawal.
     */
    public function update(User $user, TookenItem $tookenItem): bool
    {
        // Only admin can update withdrawals (for corrections)
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the withdrawal.
     */
    public function delete(User $user, TookenItem $tookenItem): bool
    {
        // Only admin can delete withdrawals
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore deleted withdrawals.
     */
    public function restore(User $user, TookenItem $tookenItem): bool
    {
        // Only admin can restore withdrawals
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete withdrawals.
     */
    public function forceDelete(User $user, TookenItem $tookenItem): bool
    {
        // Only admin can force delete
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view withdrawal statistics.
     */
    public function viewStatistics(User $user): bool
    {
        // Only admin can view statistics
        return $user->role === 'admin';
    }
}
