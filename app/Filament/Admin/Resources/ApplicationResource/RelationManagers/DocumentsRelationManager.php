<?php

namespace App\Filament\Admin\Resources\ApplicationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('document_type')
                    ->label('Document Name/Type')
                    ->required()
                    ->maxLength(191)
                    ->placeholder('e.g., Passport, Transcript, Recommendation Letter')
                    ->helperText('Give this document a descriptive name'),

                Forms\Components\FileUpload::make('file_path')
                    ->label('Document File')
                    ->required()
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'])
                    ->maxSize(2048)
                    ->disk('public')
                    ->directory(fn ($record) => 'applications/' . $this->getOwnerRecord()->id)
                    ->downloadable()
                    ->openable()
                    ->previewable(true)
                    ->helperText('Accepted formats: PDF, JPG, PNG (Max: 2MB)')
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('file_name', $state->getClientOriginalName());
                            $set('file_size', $state->getSize());
                            $set('mime_type', $state->getMimeType());
                        }
                    }),

                Forms\Components\Hidden::make('file_name'),
                Forms\Components\Hidden::make('file_size'),
                Forms\Components\Hidden::make('mime_type'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('document_type')
            ->columns([
                Tables\Columns\TextColumn::make('document_type')
                    ->label('Document Type')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('file_name')
                    ->label('File Name')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->file_name),

                Tables\Columns\TextColumn::make('formatted_file_size')
                    ->label('Size')
                    ->sortable(['file_size']),

                Tables\Columns\IconColumn::make('mime_type')
                    ->label('Type')
                    ->icon(fn (string $state): string => match (true) {
                        str_contains($state, 'pdf') => 'heroicon-o-document-text',
                        str_contains($state, 'image') => 'heroicon-o-photo',
                        default => 'heroicon-o-document',
                    })
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'pdf') => 'danger',
                        str_contains($state, 'image') => 'success',
                        default => 'gray',
                    })
                    ->tooltip(fn ($record) => strtoupper(explode('/', $record->mime_type)[1] ?? 'File')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Document')
                    ->icon('heroicon-o-plus')
                    ->mutateFormDataUsing(function (array $data): array {
                        // Store the file and update the data
                        if (isset($data['file_path']) && is_object($data['file_path'])) {
                            $file = $data['file_path'];
                            $data['file_name'] = $file->getClientOriginalName();
                            $data['file_size'] = $file->getSize();
                            $data['mime_type'] = $file->getMimeType();
                        }
                        return $data;
                    })
                    ->after(function () {
                        Notification::make()
                            ->success()
                            ->title('Document uploaded successfully')
                            ->send();
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn ($record) => Storage::disk('public')->url($record->file_path))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(fn ($record) => Storage::disk('public')->download($record->file_path, $record->file_name)),

                Tables\Actions\EditAction::make()
                    ->label('Replace')
                    ->icon('heroicon-o-arrow-path')
                    ->mutateFormDataUsing(function (array $data): array {
                        // Handle file replacement
                        if (isset($data['file_path']) && is_object($data['file_path'])) {
                            $file = $data['file_path'];
                            $data['file_name'] = $file->getClientOriginalName();
                            $data['file_size'] = $file->getSize();
                            $data['mime_type'] = $file->getMimeType();
                        }
                        return $data;
                    })
                    ->after(function () {
                        Notification::make()
                            ->success()
                            ->title('Document updated successfully')
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->after(function () {
                        Notification::make()
                            ->success()
                            ->title('Document deleted successfully')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('No documents uploaded')
            ->emptyStateDescription('Upload documents to support this application.')
            ->emptyStateIcon('heroicon-o-document')
            ->defaultSort('created_at', 'desc');
    }
}
