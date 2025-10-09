<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ContactDetailResource\Pages;
use App\Filament\Admin\Resources\ContactDetailResource\RelationManagers;
use App\Models\ContactDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactDetailResource extends Resource
{
    protected static ?string $model = ContactDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Contact Details';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->required()
                            ->maxLength(191)
                            ->unique(ignoreRecord: true)
                            ->helperText('Unique identifier (e.g., email, phone, address)'),
                        Forms\Components\TextInput::make('label')
                            ->required()
                            ->maxLength(191)
                            ->helperText('Display label (e.g., Email Address, Phone Number)'),
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'text' => 'Text',
                                'email' => 'Email',
                                'phone' => 'Phone',
                                'url' => 'URL',
                                'address' => 'Address',
                            ])
                            ->default('text')
                            ->reactive(),
                        Forms\Components\Textarea::make('value')
                            ->required()
                            ->rows(3)
                            ->helperText('The actual contact information'),
                    ])->columns(2),

                Forms\Components\Section::make('Display Settings')
                    ->schema([
                        Forms\Components\TextInput::make('icon')
                            ->maxLength(191)
                            ->placeholder('heroicon-o-envelope')
                            ->helperText('Heroicon class name (optional)'),
                        Forms\Components\TextInput::make('order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Display order (lower numbers appear first)'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Toggle to show/hide on frontend'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50),
                Tables\Columns\TextColumn::make('label')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'text',
                        'success' => 'email',
                        'info' => 'phone',
                        'warning' => 'url',
                        'secondary' => 'address',
                    ]),
                Tables\Columns\TextColumn::make('value')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('icon')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'email' => 'Email',
                        'phone' => 'Phone',
                        'url' => 'URL',
                        'address' => 'Address',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All contacts')
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
            ->defaultSort('order', 'asc')
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
            'index' => Pages\ListContactDetails::route('/'),
            'create' => Pages\CreateContactDetail::route('/create'),
            'edit' => Pages\EditContactDetail::route('/{record}/edit'),
        ];
    }
}
