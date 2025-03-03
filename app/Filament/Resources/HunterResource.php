<?php

namespace App\Filament\Resources;

use App\Enums\HunterTypeEnum;
use App\Filament\Resources\HunterResource\Pages;
use App\Filament\Resources\HunterResource\RelationManagers;
use App\Models\Hunter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class HunterResource extends Resource
{
    protected static ?string $model = Hunter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('rank')
                    ->options([
                        'S' => 'S Rank',
                        'A' => 'A Rank',
                        'B' => 'B Rank',
                        'C' => 'C Rank',
                        'D' => 'D Rank',
                        'E' => 'E Rank',
                    ]),
                Select::make('type')
                    ->required()
                    ->options(HunterTypeEnum::class)
                    ->required(),
                TextInput::make('level')
                    ->numeric()
                    ->default(1)
                    ->required(),
                    
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('rank')->sortable(),
                TextColumn::make('level')->sortable(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHunters::route('/'),
            'create' => Pages\CreateHunter::route('/create'),
            'edit' => Pages\EditHunter::route('/{record}/edit'),
        ];
    }
}
