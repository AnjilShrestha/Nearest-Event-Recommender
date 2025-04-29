<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\foundation\Auth\User as Authenticatable;

class admin extends Authenticatable
{
    //
    //
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];
    public $timestamps = false;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
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
        ];
    }
    /**
     * The attributes that should be appended to the model's array form.
     *
     * @return list<string>
     */
    protected function appends(): array
    {
        return [
            'is_admin',
        ];
    }
    /**
     * Get the value of is_admin.
     *
     * @return bool
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->is_admin;
    }
    /**
     * Set the value of is_admin.
     *
     * @param  bool  $is_admin
     * @return void
     */
    public function setIsAdminAttribute(bool $is_admin): void
    {
        $this->attributes['is_admin'] = $is_admin;
    }
    
}
