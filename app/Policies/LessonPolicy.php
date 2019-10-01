<?php

namespace App\Policies;

use App\Lesson;
use App\Role\UserRole;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any grades.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the grade.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return mixed
     */
    public function view(User $user, Lesson $lesson)
    {
        //
    }

    /**
     * Determine whether the user can create grades.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole(UserRole::ROLE_ADMIN);
    }

    /**
     * Determine whether the user can update the grade.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return mixed
     */
    public function update(User $user, Lesson $lesson)
    {
        return $user->hasRole(UserRole::ROLE_ADMIN);
    }

    /**
     * Determine whether the user can delete the grade.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return mixed
     */
    public function delete(User $user, Lesson $lesson)
    {
        return $user->hasRole(UserRole::ROLE_ADMIN);
    }

    /**
     * Determine whether the user can restore the grade.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return mixed
     */
    public function restore(User $user, Lesson $lesson)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the grade.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return mixed
     */
    public function forceDelete(User $user, Lesson $lesson)
    {
        //
    }
}
