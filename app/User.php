<?php

namespace App;

use App\Role\UserRole;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles' => 'array',
    ];

    /***
     * @param string $role
     * @return $this
     */
    public function addRole($role)
    {
        $roles = $this->getRoles();
        $roles[] = $role;

        $roles = array_unique($roles);
        $this->setRoles($roles);

        return $this;
    }

    /***
     * @param string $role
     * @return $this
     */
    public function removeRole($role)
    {
        $roles = $this->getRoles();
        if (($key = array_search($role, $roles)) !== false) {
            unset($roles[$key]);
        }
        $this->setRoles($roles);

        return $this;
    }


    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->setAttribute('roles', $roles);
        return $this;
    }

    /***
     * @param $role
     * @return mixed
     */
    public function hasRole($role)
    {
        return in_array($role, $this->getRoles());
    }

    /***
     * @param $roles
     * @return mixed
     */
    public function hasRoles($roles)
    {
        $currentRoles = $this->getRoles();
        foreach ($roles as $role) {
            if (!in_array($role, $currentRoles)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->getAttribute('roles');

        if (is_null($roles)) {
            $roles = [];
        }

        return $roles;
    }

    public function setRoleAttribute($value)
    {
        if (!$value) {
            return $this->setRoles([]);
        }
        return $this->setRoles([$value]);
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
    public function scopeTeachers($query) {
        $teacherRole = UserRole::ROLE_TEACHER;
        return $query->where('roles', 'LIKE', "%$teacherRole%");
    }
}
