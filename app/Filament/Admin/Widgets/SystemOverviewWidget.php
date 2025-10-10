<?php

namespace App\Filament\Admin\Widgets;

use App\Models\University;
use App\Models\Course;
use App\Models\School;
use App\Models\ContactMessage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $totalUniversities = University::count();
        $activeUniversities = University::where('is_active', true)->count();

        $totalCourses = Course::count();
        $activeCourses = Course::where('is_active', true)->count();

        $totalSchools = School::count();
        $activeSchools = School::where('is_active', true)->count();

        $unreadMessages = ContactMessage::where('is_read', false)->count();

        return [
            Stat::make('Universities', $totalUniversities)
                ->description($activeUniversities . ' active')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('success')
                ->url(route('filament.admin.resources.universities.index')),

            Stat::make('Courses', $totalCourses)
                ->description($activeCourses . ' active programs')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info')
                ->url(route('filament.admin.resources.courses.index')),

            Stat::make('Partner Schools', $totalSchools)
                ->description($activeSchools . ' active partnerships')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('warning')
                ->url(route('filament.admin.resources.schools.index')),

            Stat::make('Unread Messages', $unreadMessages)
                ->description('Contact inquiries')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadMessages > 0 ? 'danger' : 'success')
                ->url(route('filament.admin.resources.contact-messages.index', ['tableFilters[is_read][value]' => false])),
        ];
    }
}
