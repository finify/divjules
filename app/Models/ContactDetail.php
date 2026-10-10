<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'label',
        'value',
        'icon',
        'type',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope to get only active contact details
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by the order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get formatted value based on type
     */
    public function getFormattedValueAttribute(): string
    {
        return match($this->type) {
            'email' => $this->value,
            'phone' => $this->value,
            'url' => $this->value,
            'address' => nl2br(e($this->value)),
            default => e($this->value),
        };
    }

    /**
     * Get the link for clickable types
     */
    public function getLinkAttribute(): ?string
    {
        return match($this->type) {
            'email' => 'mailto:' . $this->value,
            'phone' => 'tel:' . preg_replace('/[^0-9+]/', '', $this->value),
            'url' => $this->value,
            default => null,
        };
    }

    /**
     * Check if this contact detail is clickable
     */
    public function getIsClickableAttribute(): bool
    {
        return in_array($this->type, ['email', 'phone', 'url']);
    }

    /** Full Font Awesome class for the stored (heroicon-style) icon name. */
    public function getFaIconAttribute(): string
    {
        $haystack = strtolower(($this->key ?? '') . ' ' . ($this->label ?? ''));
        if (str_contains($haystack, 'whatsapp')) {
            return 'fab fa-whatsapp';
        }

        $name = str_replace(['heroicon-o-', 'heroicon-s-', 'fa-', 'fas ', 'far ', 'fab '], '', (string) $this->icon);
        $map = [
            'envelope' => 'envelope', 'phone' => 'phone', 'map-pin' => 'location-dot', 'globe-alt' => 'globe',
            'clock' => 'clock', 'chat-bubble-left-right' => 'comments', 'chat-bubble-left' => 'comment', 'building-office' => 'building',
        ];

        return 'fas fa-' . ($map[$name] ?? ($name ?: 'circle-info'));
    }
}
