<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'status', 'published_at', 'user_id', 'publication_state'];
    
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public const STATE_DRAFT = 'draft';
    public const STATE_PUBLISHED = 'published';
    public const STATE_SCHEDULED = 'scheduled';
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function scopePublished($query)
    {
        return $query->where(function ($q) {
                        $q->where('publication_state', self::STATE_PUBLISHED)
                          ->orWhere('status', self::STATE_PUBLISHED);
                    })
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('publication_state', self::STATE_DRAFT);
    }

    public function scopeScheduled($query)
    {
        return $query->where('publication_state', self::STATE_SCHEDULED)
                     ->where('published_at', '>', now());
    }

    public function isPublished(): bool
    {
        return $this->publication_state === self::STATE_PUBLISHED && $this->published_at && $this->published_at->lte(now());
    }

    public function publishNow(): bool
    {
        $this->publication_state = self::STATE_PUBLISHED;
        $this->published_at = now();
        $this->status = self::STATE_PUBLISHED;
        return $this->save();
    }

    public function scheduleFor($when): bool
    {
        $dt = $when instanceof \DateTimeInterface ? \Illuminate\Support\Carbon::instance($when) : \Illuminate\Support\Carbon::parse($when);
        $this->published_at = $dt;
        $this->publication_state = $dt->gt(now()) ? self::STATE_SCHEDULED : self::STATE_PUBLISHED;
        $this->status = $this->publication_state === self::STATE_PUBLISHED ? self::STATE_PUBLISHED : 'draft';
        return $this->save();
    }
}
