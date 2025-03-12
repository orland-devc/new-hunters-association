<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeInResource\Pages;
use App\Filament\Resources\TimeInResource\RelationManagers;
use App\Models\DiscordTimeIn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class TimeInResource extends Resource
{
    protected static ?string $model = DiscordTimeIn::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Discord Time Tracking';
    protected static ?string $modelLabel = 'Discord Time In';
    protected static ?string $pluralModelLabel = 'Discord Time Ins';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('discord_avatar')
                    ->circular()
                    ->getStateUsing(function ($record): string {
                        return "https://cdn.discordapp.com/avatars/{$record->discord_user_id}/{$record->discord_avatar}.png";
                    })
                    ->label('Avatar'),
                Tables\Columns\TextColumn::make('discord_username')
                    ->searchable()
                    ->sortable()
                    ->label('Discord Username'),
                Tables\Columns\TextColumn::make('discord_user_id')
                    ->searchable()
                    ->sortable()
                    ->label('Discord User ID'),
                    Tables\Columns\TextColumn::make('time_in')
                    ->dateTime()
                    ->sortable()
                    ->label('Time In'),
                Tables\Columns\TextColumn::make('time_out')
                    ->dateTime()
                    ->sortable()
                    ->label('Time Out'),
                Tables\Columns\TextColumn::make('duration')
                    ->sortable()
                    ->getStateUsing(function ($record): ?string {
                        if (empty($record->time_out)) {
                            return null;
                        }
                        
                        $timeIn = new \Carbon\Carbon($record->time_in);
                        $timeOut = new \Carbon\Carbon($record->time_out);
                        
                        return $timeIn->diffForHumans($timeOut, ['parts' => 2, 'short' => true, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]);                        
                    })
                    ->label('Duration'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('active_sessions')
                    ->query(fn (Builder $query): Builder => $query->whereNull('time_out'))
                    ->toggle()
                    ->label('Active Sessions'),
                Tables\Filters\Filter::make('completed_sessions')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('time_out'))
                    ->toggle()
                    ->label('Completed Sessions'),
                Tables\Filters\Filter::make('time_in'),
            ])
            ->actions([
                Tables\Actions\Action::make('check_out')
                    ->action(function (DiscordTimeIn $record): void {
                        if ($record->time_out === null) {
                            $record->update(['time_out' => now()]);
                        }
                    })
                    ->requiresConfirmation()
                    ->hidden(fn (DiscordTimeIn $record): bool => $record->time_out !== null)
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->label('Check Out'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('bulk_check_out')
                        ->action(function (Collection $records): void {
                            $records->each(function (DiscordTimeIn $record): void {
                                if ($record->time_out === null) {
                                    $record->update(['time_out' => now()]);
                                }
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->color('success')
                        ->icon('heroicon-o-check-circle')
                        ->label('Check Out Selected'),
                ]),
            ]);
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
            'index' => Pages\ListTimeIns::route('/'),
        ];
    }
}