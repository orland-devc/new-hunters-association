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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class TimeInResource extends Resource
{
    protected static ?string $model = DiscordTimeIn::class;

    protected static ?string $navigationIcon = 'lucide-hourglass';
    protected static ?string $navigationLabel = 'Discord Time Tracking';
    protected static ?string $modelLabel = 'Discord Time In';
    protected static ?string $pluralModelLabel = 'Discord Time Ins';

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('time_in', 'desc')
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
                Tables\Columns\TextColumn::make('time_in')
                    ->dateTime('g:i A')
                    ->sortable()
                    ->label('Time In'),
                Tables\Columns\TextColumn::make('time_out')
                    ->dateTime('g:i A')
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
                        
                        // Calculate the difference in hours and minutes
                        $duration = $timeIn->diff($timeOut);
                        return sprintf('%dh %dm', $duration->h, $duration->i); // Format: "Xh Ym"
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
            ->groups([
                Tables\Grouping\Group::make('time_in')
                    ->label('Date')
                    ->date()
                    ->collapsible()
            ])
            ->defaultGroup('time_in') // Group by default
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
                Tables\Actions\Action::make('test_send_image')
                    ->action(function (DiscordTimeIn $record): void {
                        $fileUrl = asset('images/image.png');
                        $response = Http::post('http://localhost:3000/send-image', [
                            'discord_user_id' => $record->discord_user_id,
                            'file_url' => $fileUrl,
                        ]);          
                        
                        if ($response->successful()) {
                            \Filament\Notifications\Notification::make()
                                ->title('Success')
                                ->body('The image was successfully sent!')
                                ->success()
                                ->send();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Error')
                                ->body('Failed to send the image.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->color('secondary')
                    ->icon('lucide-send')
                    ->label('Test'),

                Tables\Actions\Action::make('check_out')
                    ->action(function (DiscordTimeIn $record): void {
                        if ($record->time_out === null) {
                            $record->update(['time_out' => now()]);
    
                            Http::post('http://localhost:3000/notify-checkout', [
                                'discord_user_id' => $record->discord_user_id,
                                'admin_name' => Auth::user()->name,
                                'formatted_time' => now()->format('F j, \\a\\t g:i A'),
                            ]);                            
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
                    // Tables\Actions\BulkAction::make('test_send_image')
                    //     ->action(function (Collection $records): void {
                    //         $records->each(function (DiscordTimeIn $record): void {
                    //             Http::post('http://localhost:3000/send-image', [
                    //                 'discord_user_id' => $record->discord_user_id,
                    //             ]);
                    //         });
                    //     })
                    //     ->requiresConfirmation()
                    //     ->color('secondary')
                    //     ->icon('lucide-send')
                    //     ->label('Test Selected'),
                    Tables\Actions\BulkAction::make('bulk_check_out')
                        ->action(function (Collection $records): void {
                            $records->each(function (DiscordTimeIn $record): void {
                                if ($record->time_out === null) {
                                    $record->update(['time_out' => now()]);
                                    
                                    // Send DM to the Discord bot localhost for each checked-out user
                                    Http::post('http://localhost:3000/notify-checkout', [
                                        'discord_user_id' => $record->discord_user_id,
                                        'admin_name' => Auth::user()->name,
                                        'formatted_time' => now()->format('F j, \\a\\t g:i A'),
                                    ]);                                    
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
