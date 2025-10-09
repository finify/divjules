<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CourseResource\Pages;
use App\Models\Course;
use App\Models\University;
use App\Models\CourseCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Courses';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\Select::make('university_id')
                            ->label('University')
                            ->relationship('university', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                                Forms\Components\Select::make('country')
                                    ->required()
                                    ->options([
                                        'United Kingdom' => 'United Kingdom',
                                        'United States' => 'United States',
                                        'Canada' => 'Canada',
                                        'Australia' => 'Australia',
                                    ]),
                            ]),

                        Forms\Components\Select::make('course_category_id')
                            ->label('Category')
                            ->relationship('courseCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                                Forms\Components\TextInput::make('icon')
                                    ->helperText('FontAwesome icon name'),
                            ]),

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state)))
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Course Details')
                    ->schema([
                        Forms\Components\Select::make('level')
                            ->required()
                            ->options([
                                'undergraduate' => 'Undergraduate',
                                'postgraduate' => 'Postgraduate',
                                'diploma' => 'Diploma',
                                'certificate' => 'Certificate',
                            ])
                            ->native(false),

                        Forms\Components\TextInput::make('duration')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., 3 years, 18 months'),

                        Forms\Components\TextInput::make('mode_of_study')
                            ->maxLength(255)
                            ->placeholder('e.g., Full-time, Part-time, Online'),

                        Forms\Components\TextInput::make('tuition_fee')
                            ->numeric()
                            ->prefix('$')
                            ->maxValue(999999.99),

                        Forms\Components\Select::make('currency')
                            ->options([
                                'USD' => 'USD',
                                'GBP' => 'GBP',
                                'EUR' => 'EUR',
                                'AUD' => 'AUD',
                                'CAD' => 'CAD',
                            ])
                            ->default('USD')
                            ->native(false),

                        Forms\Components\DatePicker::make('intake_start')
                            ->label('Intake Start Date'),

                        Forms\Components\DatePicker::make('intake_end')
                            ->label('Intake End Date'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\TagsInput::make('entry_requirements')
                            ->helperText('Press enter after each requirement')
                            ->columnSpanFull(),

                        Forms\Components\TagsInput::make('career_prospects')
                            ->helperText('Press enter after each career path')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured')
                            ->helperText('Show on homepage'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Show on website'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('university.name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('courseCategory.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('level')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'undergraduate' => 'success',
                        'postgraduate' => 'warning',
                        'diploma' => 'info',
                        'certificate' => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('duration')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tuition_fee')
                    ->money(fn ($record) => $record->currency)
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('university')
                    ->relationship('university', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('courseCategory')
                    ->relationship('courseCategory', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('level')
                    ->options([
                        'undergraduate' => 'Undergraduate',
                        'postgraduate' => 'Postgraduate',
                        'diploma' => 'Diploma',
                        'certificate' => 'Certificate',
                    ]),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
