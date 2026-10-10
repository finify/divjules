<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'banner_image',
        'country',
        'city',
        'address',
        'website',
        'type',
        'ranking',
        'contact_email',
        'contact_phone',
        'features',
        'order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'ranking' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($university) {
            if (empty($university->slug)) {
                $university->slug = Str::slug($university->name);
            }
        });
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo) {
            return asset(Storage::url($this->logo));
        }
        return null;
    }

    public function getBannerImageUrlAttribute(): ?string
    {
        if ($this->banner_image) {
            return asset(Storage::url($this->banner_image));
        }
        return null;
    }

    /** Banner image, or a photo of the destination country when none was uploaded. */
    public function getCoverUrlAttribute(): string
    {
        if ($this->banner_image_url) {
            return $this->banner_image_url;
        }
        $key = match (strtolower((string) $this->country)) {
            'united kingdom', 'uk', 'england', 'scotland', 'wales', 'northern ireland' => 'uk',
            'canada' => 'canada',
            'united states', 'usa', 'united states of america', 'us' => 'usa',
            'australia' => 'australia',
            'germany' => 'germany',
            'ireland' => 'ireland',
            'united arab emirates', 'uae', 'dubai' => 'dubai',
            default => null,
        };

        // mix the country photo with campus shots so a grid of same-country cards doesn't repeat
        $pool = ['campus', 'library-modern', 'lecture-hall', 'auditorium', 'students-library', 'seminar', 'library-shelves'];
        $id = (int) $this->id;
        $image = ($key && $id % 3 === 0) || ! $id ? ($key ? "dest-{$key}" : 'campus') : $pool[$id % count($pool)];

        return asset("homeassets/img/site/{$image}.webp");
    }

    /** Up to two initials for logo-less universities, e.g. "University of Kent" → "UK". */
    public function getInitialsAttribute(): string
    {
        $words = collect(preg_split('/[\s\-]+/', $this->name))
            ->reject(fn ($w) => in_array(strtolower($w), ['of', 'the', 'and', 'in', 'for', 'at', '&']))
            ->values();

        return strtoupper(mb_substr($words[0] ?? '', 0, 1) . mb_substr($words[1] ?? '', 0, 1));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function scopeByCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
