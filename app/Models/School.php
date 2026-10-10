<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo_url',
        'country',
        'website_url',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /** Uploaded logo, or the logo bundled with the site for a matching university name. */
    public function getLogoSrcAttribute(): ?string
    {
        return $this->logo_url ? '/storage/' . ltrim($this->logo_url, '/') : University::bundledLogo($this->name);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
