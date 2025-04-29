<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EventOrganizer extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    //
    protected $table = 'event_organizer';
    protected $fillable = [
        'name',
        'email',
        'company_name',
        'company_logo',
        'company_phone',
        'company_address',
        'company_website',
        'company_description',
        'username',
        'password',
        'status',
    ];
    public $timestamps = false;
}
