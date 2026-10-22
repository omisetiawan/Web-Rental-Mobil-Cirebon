<?php
namespace App\Traits;

trait HasRolesPermissions
{
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'role_user');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }
}
