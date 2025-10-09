<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number',
        'application_stage_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'nationality',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'university_id',
        'course_id',
        'previous_education',
        'english_proficiency',
        'form_data',
        'status',
        'admin_notes',
        'submitted_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'form_data' => 'array',
        'submitted_at' => 'datetime',
    ];

    /**
     * Boot method to generate unique application number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            if (empty($application->application_number)) {
                $application->application_number = self::generateApplicationNumber();
            }
        });
    }

    /**
     * Generate unique application number
     */
    public static function generateApplicationNumber(): string
    {
        do {
            $number = 'APP-' . date('Y') . '-' . strtoupper(Str::random(8));
        } while (self::where('application_number', $number)->exists());

        return $number;
    }

    /**
     * Get the application stage
     */
    public function applicationStage(): BelongsTo
    {
        return $this->belongsTo(ApplicationStage::class);
    }

    /**
     * Get the university
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    /**
     * Get the course
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get all documents for this application
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Scope to filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by submitted applications
     */
    public function scopeSubmitted($query)
    {
        return $query->whereNotNull('submitted_at');
    }

    /**
     * Scope to filter by draft applications
     */
    public function scopeDraft($query)
    {
        return $query->whereNull('submitted_at');
    }
}
