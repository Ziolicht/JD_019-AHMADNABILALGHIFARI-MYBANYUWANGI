<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'location',
        'starts_at',
        'ends_at',
        'contact_whatsapp',
        'image_path',
        'is_published',
        'created_by'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'is_published' => 'boolean',
    ];

    // auto slug on creating if empty
    protected static function booted()
    {
        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title . '-' . Str::random(5));
            }
        });
    }

    // scopes
    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }
    public function scopeUpcoming($q)
    {
        return $q->where('starts_at', '>=', now())->orderBy('starts_at');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    
}
