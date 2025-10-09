<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'course_category_id',
        'name',
        'slug',
        'description',
        'level',
        'duration',
        'tuition_fee',
        'currency',
        'intake_start',
        'intake_end',
        'entry_requirements',
        'mode_of_study',
        'career_prospects',
        'order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'entry_requirements' => 'array',
        'career_prospects' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'tuition_fee' => 'decimal:2',
        'intake_start' => 'date',
        'intake_end' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->name);
            }
        });
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function courseCategory(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function getFormattedTuitionFeeAttribute(): string
    {
        if ($this->tuition_fee) {
            return $this->currency . ' ' . number_format($this->tuition_fee, 2);
        }
        return 'Contact for pricing';
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

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('course_category_id', $categoryId);
    }

    public function scopeByUniversity($query, $universityId)
    {
        return $query->where('university_id', $universityId);
    }
}
