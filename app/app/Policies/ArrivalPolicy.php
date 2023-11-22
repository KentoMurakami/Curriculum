<?php

namespace App\Policies;

use App\Arrival;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArrivalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any arrivals.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the arrival.
     *
     * @param  \App\User  $user
     * @param  \App\Arrival  $arrival
     * @return mixed
     */
    public function view(User $user, Arrival $arrival)
    {
        return $user->store_id === $arrival->store_id;
    }

    /**
     * Determine whether the user can create arrivals.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the arrival.
     *
     * @param  \App\User  $user
     * @param  \App\Arrival  $arrival
     * @return mixed
     */
    public function update(User $user, Arrival $arrival)
    {
        //
    }

    /**
     * Determine whether the user can delete the arrival.
     *
     * @param  \App\User  $user
     * @param  \App\Arrival  $arrival
     * @return mixed
     */
    public function delete(User $user, Arrival $arrival)
    {
        //
    }

    /**
     * Determine whether the user can restore the arrival.
     *
     * @param  \App\User  $user
     * @param  \App\Arrival  $arrival
     * @return mixed
     */
    public function restore(User $user, Arrival $arrival)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the arrival.
     *
     * @param  \App\User  $user
     * @param  \App\Arrival  $arrival
     * @return mixed
     */
    public function forceDelete(User $user, Arrival $arrival)
    {
        //
    }
}
