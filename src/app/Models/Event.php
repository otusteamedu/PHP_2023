<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'type_id'];

    public function type()
    {
        return $this->belongsTo(EventType::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscribers_events');
    }
}
