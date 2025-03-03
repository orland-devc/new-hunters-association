<?php

namespace App\Filament\Clusters\Salary\Resources;

use App\Filament\Clusters\Salary;
use App\Filament\Clusters\Salary\Resources\RaidsResource\Pages;
use App\Filament\Clusters\Salary\Resources\RaidsResource\RelationManagers;
use App\Models\Raids;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RaidsResource extends Resource
{
    protected static ?string $model = Raids::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Salary::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListRaids::route('/'),
            'create' => Pages\CreateRaids::route('/create'),
            'edit' => Pages\EditRaids::route('/{record}/edit'),
        ];
    }
}
