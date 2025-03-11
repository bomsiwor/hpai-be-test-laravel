<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];

    /**
     * Define the many-to-many relationship with User model.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_has_users', 'role_id', 'user_id');
    }
}
