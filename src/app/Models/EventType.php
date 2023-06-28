<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $fillable = ['type'];

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscriber_event_types');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
