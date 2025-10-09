<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VideoTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'course',
        'university',
        'thumbnail_image',
        'youtube_url',
        'rating',
        'quote',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rating' => 'integer',
        'order' => 'integer',
    ];

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail_image) {
            return Storage::url($this->thumbnail_image);
        }
        return null;
    }

    public function getDisplayThumbnailAttribute(): string
    {
        // Return custom thumbnail if uploaded
        if ($this->thumbnail_image) {
            return asset(Storage::url($this->thumbnail_image));
        }

        // Otherwise, extract YouTube thumbnail
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $this->youtube_url, $matches);
        $videoId = $matches[1] ?? null;

        return $videoId
            ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"
            : 'https://via.placeholder.com/600x400?text=No+Thumbnail';
    }

    public function getYoutubeEmbedUrlAttribute(): string
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $this->youtube_url, $matches);
        $videoId = $matches[1] ?? null;
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : $this->youtube_url;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }
}
