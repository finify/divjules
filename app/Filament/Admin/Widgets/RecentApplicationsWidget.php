<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Application;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentApplicationsWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Application::query()
                    ->with(['university', 'course', 'applicationStage'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('application_number')
                    ->label('App #')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('full_name')
                    ->label('Applicant')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),

                Tables\Columns\TextColumn::make('university.name')
                    ->label('University')
                    ->limit(25)
                    ->tooltip(fn ($record) => $record->university?->name)
                    ->sortable(),

                Tables\Columns\TextColumn::make('course.name')
                    ->label('Course')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->course?->name),

                Tables\Columns\BadgeColumn::make('applicationStage.name')
                    ->label('Stage')
                    ->colors([
                        'primary' => fn ($record) => $record->applicationStage?->color ?? '#9333ea',
                    ]),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'submitted',
                        'primary' => 'processing',
                        'success' => 'completed',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime('M d, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Application $record): string => route('filament.admin.resources.applications.edit', ['record' => $record])),
            ])
            ->heading('Recent Applications')
            ->description('Latest 10 application submissions')
            ->defaultSort('created_at', 'desc');
    }
}
