<?php

namespace App\Filament\Clusters\Salary\Resources;

use App\Filament\Clusters\Salary;
use App\Filament\Clusters\Salary\Resources\PayrollResource\Pages;
use App\Filament\Clusters\Salary\Resources\PayrollResource\RelationManagers;
use App\Models\Payroll;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationIcon = 'lucide-receipt-text';

    protected static ?string $cluster = Salary::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payroll Information')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('header')
                                            ->content(fn ($record) => '₱' . number_format($record?->total_amount ?? 0, 2))
                                            ->live()
                                            ->extraAttributes(['class' => 'text-center text-2xl font-bold'])
                                            ->hiddenLabel()
                                    ])
                                    ->columnSpan(1)
                                    ->extraAttributes(['class' => 'bg-gray-100 p-4 rounded-lg']),                                    
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\DatePicker::make('start_date')
                                            ->required()
                                            ->label('Start Date')
                                            ->default(now()->startOfMonth()),
                                        Forms\Components\DatePicker::make('end_date')
                                            ->required()
                                            ->label('End Date')
                                            ->default(now()->endOfMonth()),
                                    ])
                                    ->columnSpan(3),
                                    
                                Forms\Components\TextInput::make('total_amount')
                                    ->live()
                                    ->readOnly()
                                    ->default(0)
                                    ->prefix('₱')
                                    ->numeric()
                                    ->label('Total Amount')
                                    ->hidden() // Hide the original input
                            ])
                    ]),
            ]);
    }


    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_date')->date(),
                Tables\Columns\TextColumn::make('end_date')->date(),
                Tables\Columns\TextColumn::make('total_amount')->money('PHP'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
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
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
        ];
    }
}
