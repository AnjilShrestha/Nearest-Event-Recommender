<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'starttime',
        'endtime',
        'location',
        'latitude',
        'longitude',
        'image',
        'features',
        'tags',
        'is_paid',
        'price',
        'organizer_id',
        'category_id',
    ];
    protected $casts = [
        'features' => 'array',
        'tags'=>'array',
    ];


    public $timestamps=false;
    public function organizer()
    {
        return $this->belongsTo(EventOrganizer::class, 'organizer_id');
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }
}
