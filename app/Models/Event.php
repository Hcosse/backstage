<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'location', 'date',
        'category', 'max_participants', 'slug', 'user_id'
    ];

    // Génération automatique du slug lors de la création
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            $event->slug = Str::slug($event->title);
        });
    }

    // Relation : un événement appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
