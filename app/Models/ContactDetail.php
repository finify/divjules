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
}
