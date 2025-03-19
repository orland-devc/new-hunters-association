<?php

namespace App\Filament\Clusters\Salary\Resources;

use App\Filament\Clusters\Salary;
use App\Filament\Clusters\Salary\Resources\EmployeeResource\Pages;
use App\Filament\Clusters\Salary\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'lucide-square-user-round';

    protected static ?string $cluster = Salary::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('phone')->tel(),
                Forms\Components\TextInput::make('position')->required(),
                Forms\Components\Select::make('salary_type')
                ->options([
                    'hourly' => 'Hourly',
                    'daily' => 'Daily',
                    'weekly' => 'Weekly',
                    'biweekly' => 'Biweekly',
                    'monthly' => 'Monthly',
                ])
                ->preload()->required(),
                Forms\Components\TextInput::make('salary')->numeric()->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('position'),
                Tables\Columns\TextColumn::make('salary')->money('PHP'),
                Tables\Columns\TextColumn::make('salary_type')
                    ->badge(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
