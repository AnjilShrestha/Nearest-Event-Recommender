<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Event;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventCategory extends Model
{
    //
    use HasFactory;
    protected $table = 'eventcategories';
    protected $fillable = [
        'categories_name',
    ];
    public $timestamps = false;
    public function events()
    {
        return $this->hasMany(Event::class, 'category_id');
    }
   
}
