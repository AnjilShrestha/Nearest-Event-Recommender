<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketPurchased extends Model
{
    //
    protected $table='ticket_purchased';
    protected $fillable=[
        'quantity',
        'total',
        'transaction_id',
        'payment_status',
        'payment_method',
        'user_id',
        'event_id',
    ];
    public $timestamps=false;
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
