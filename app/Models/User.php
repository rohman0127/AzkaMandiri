<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'password', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'model_has_roles');
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string|array $roles): bool
    {
        $rolesArray = is_array($roles) ? $roles : func_get_args();

        return $this->roles->contains(function ($role) use ($rolesArray) {
            return in_array($role->name, $rolesArray) || in_array($role->slug, $rolesArray);
        });
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(...$roles): bool
    {
        return $this->hasRole($roles);
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permissionName): bool
    {
        // Inactive users have no permissions
        if (!$this->is_active) {
            return false;
        }

        // Super Admin bypasses all checks
        if ($this->hasRole(['Super Admin', 'super-admin'])) {
            return true;
        }

        // Check if any assigned role has this permission
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permissionName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Assign a role to user
     */
    public function assignRole(int|string|Role $role): void
    {
        if (is_string($role)) {
            $roleModel = Role::where('name', $role)->orWhere('slug', $role)->firstOrFail();
            $this->roles()->syncWithoutDetaching([$roleModel->id]);
        } elseif (is_numeric($role)) {
            $this->roles()->syncWithoutDetaching([$role]);
        } elseif ($role instanceof Role) {
            $this->roles()->syncWithoutDetaching([$role->id]);
        }
    }

    /**
     * Sync roles for user
     */
    public function syncRoles(array $roleIds): void
    {
        $this->roles()->sync($roleIds);
    }

    /**
     * Get primary role name attribute
     */
    public function getRoleNameAttribute(): string
    {
        $primary = $this->roles->first();
        return $primary ? $primary->name : 'Staff (Tanpa Role)';
    }

    /**
     * Get primary role attribute
     */
    public function getRoleAttribute(): ?Role
    {
        return $this->roles->first();
    }
}
