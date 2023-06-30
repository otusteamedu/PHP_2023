<?php

namespace App\Models;

use App\Services\Notification\EmailNotificationStrategy;
use App\Services\Notification\SmsNotificationStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'preferred_notification'];

    public function eventTypes(): BelongsToMany
    {
        return $this->belongsToMany(EventType::class, 'subscriber_event_types');
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'subscribers_events');
    }

    /**
     * @throws \Exception
     */
    public function getPreferredNotificationStrategy(): EmailNotificationStrategy|SmsNotificationStrategy
    {
        return match ($this->preferred_notification) {
            'email' => new EmailNotificationStrategy(),
            'sms' => new SmsNotificationStrategy(),
            default => throw new \Exception('Unknown notification strategy'),
        };
    }

}
