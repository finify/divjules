<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\VideoTestimonialResource\Pages;
use App\Filament\Admin\Resources\VideoTestimonialResource\RelationManagers;
use App\Models\VideoTestimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VideoTestimonialResource extends Resource
{
    protected static ?string $model = VideoTestimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Video Testimonials';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Student Information')
                    ->schema([
                        Forms\Components\TextInput::make('student_name')
                            ->label('Student Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('university')
                            ->label('University')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('course')
                            ->label('Course/Program')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2)
                            ->placeholder('e.g., MSc Computer Science'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Video & Media')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail_image')
                            ->label('Thumbnail Image')
                            ->image()
                            ->disk('public')
                            ->directory('testimonials/thumbnails')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                            ])
                            ->maxSize(5120)
                            ->imagePreviewHeight('250')
                            ->downloadable()
                            ->helperText('Upload a custom thumbnail image (max 5MB). Leave empty to use YouTube thumbnail.')
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('youtube_url')
                            ->label('YouTube Video URL')
                            ->required()
                            ->url()
                            ->maxLength(255)
                            ->columnSpan(2)
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('Full YouTube video URL or embed URL'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Testimonial Details')
                    ->schema([
                        Forms\Components\Textarea::make('quote')
                            ->label('Student Quote')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpan(2)
                            ->placeholder('A short testimonial quote from the student'),

                        Forms\Components\Select::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '1 Star',
                                2 => '2 Stars',
                                3 => '3 Stars',
                                4 => '4 Stars',
                                5 => '5 Stars',
                            ])
                            ->default(5)
                            ->required()
                            ->native(false)
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first')
                            ->columnSpan(1),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Show this testimonial on the website')
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_image')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->square()
                    ->size(60)
                    ->getStateUsing(function ($record) {
                        if ($record->thumbnail_image) {
                            return $record->thumbnail_image;
                        }
                        // Extract YouTube video ID and use YouTube thumbnail as fallback
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $record->youtube_url, $matches);
                        $videoId = $matches[1] ?? null;
                        return $videoId ? "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg" : null;
                    })
                    ->defaultImageUrl('https://via.placeholder.com/150x150?text=No+Image'),

                Tables\Columns\TextColumn::make('student_name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('university')
                    ->label('University')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('course')
                    ->label('Course')
                    ->searchable()
                    ->wrap()
                    ->limit(30),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Order')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        1 => '1 Star',
                        2 => '2 Stars',
                        3 => '3 Stars',
                        4 => '4 Stars',
                        5 => '5 Stars',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All testimonials')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideoTestimonials::route('/'),
            'create' => Pages\CreateVideoTestimonial::route('/create'),
            'edit' => Pages\EditVideoTestimonial::route('/{record}/edit'),
        ];
    }
}
