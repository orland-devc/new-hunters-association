<?php

namespace App\Filament\Clusters\Salary\Resources\EmployeeResource\RelationManagers;

use App\Models\DiscordTimeIn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiscordTimeInsRelationManager extends RelationManager
{
    protected static string $relationship = 'discordTimeIns';

    public function form(Form $form): Form
    {
        return DiscordTimeIn::form($form);
    }

    // sort table by time_in in descending order

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->defaultSort('time_in', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('discord_avatar')
                    ->circular()
                    ->getStateUsing(function ($record): string {
                        return "https://cdn.discordapp.com/avatars/{$record->discord_user_id}/{$record->discord_avatar}.png";
                    })
                    ->label('Avatar'),
                Tables\Columns\TextColumn::make('created_at') 
                    ->date('F j, Y') 
                    ->sortable()
                    ->label('Date'),
                
                Tables\Columns\TextColumn::make('time_in') 
                    ->dateTime('F j \a\t g:i A') 
                    ->sortable()
                    ->label('Time In'),                
                
                Tables\Columns\TextColumn::make('time_out') 
                    ->time('g:i A')
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
