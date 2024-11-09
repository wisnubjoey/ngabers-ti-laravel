<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'event_date', 'estimated_end_date', 'meeting_point', 'destination', 'max_participants', 'status'];

    protected $casts = [
        'event_date' => 'datetime',
        'estimated_end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_participants')->withTimestamps();
    }

    public function isJoinedBy(User $user)
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    public function canBeJoined()
    {
        if ($this->status !== 'upcoming') {
            return false;
        }

       if ($this->max_participants) {
        return $this->participants()->count() < $this->max_participants;
       }

       return true;
    }

    public function updateStatus()
{
    $now = now();
    
    if ($this->event_date > $now) {
        $this->status = 'upcoming';
    } elseif ($this->event_date->addDays(1) < $now) { // Anggap event selesai 24 jam setelah waktu mulai
        $this->status = 'completed';
    } else {
        $this->status = 'ongoing';
    }
    
        $this->save();
    }
}
