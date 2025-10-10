<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestimonialStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalTestimonials = Testimonial::count();
        $pendingTestimonials = Testimonial::where('status', 'pending')->count();
        $approvedTestimonials = Testimonial::where('status', 'approved')->count();
        $featuredTestimonials = Testimonial::where('is_featured', true)->count();

        // Average rating
        $averageRating = Testimonial::where('status', 'approved')->avg('rating');

        return [
            Stat::make('Total Reviews', $totalTestimonials)
                ->description($approvedTestimonials . ' approved, ' . $pendingTestimonials . ' pending')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success'),

            Stat::make('Pending Approval', $pendingTestimonials)
                ->description('Awaiting review')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingTestimonials > 0 ? 'warning' : 'success')
                ->url(route('filament.admin.resources.testimonials.index', ['tableFilters[status][value]' => 'pending'])),

            Stat::make('Average Rating', number_format($averageRating, 1) . ' / 5')
                ->description(str_repeat('⭐', round($averageRating)))
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('Featured Reviews', $featuredTestimonials)
                ->description('Highlighted on homepage')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('info'),
        ];
    }
}
