<?php

namespace App\Filament\Clusters\Salary\Resources;

use App\Enums\EmployeePositionEnum;
use App\Enums\SalaryTypeEnum;
use App\Filament\Clusters\Salary;
use App\Filament\Clusters\Salary\Resources\EmployeeResource\Pages;
use App\Filament\Clusters\Salary\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Support\Segment;
use Illuminate\Database\Eloquent\Relations\Relation;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'lucide-square-user-round';

    protected static ?string $cluster = Salary::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('employee_id')
                            ->default(fn () => Segment::of(Employee::class)->generate()->display())
                            ->required()
                            ->formatStateUsing(function ($state) {
                                return $state ? Segment::toDisplay($state) : Segment::of(Employee::class)
                                    ->generate()
                                    ->display();
                            })
                            ->maxLength(16)
                            ->readOnly()
                            ->prefixIcon('lucide-folder-lock'),
                        Forms\Components\TextInput::make('discord_id')
                            ->required()
                            ->prefixIcon('lucide-bot'),
                        Forms\Components\TextInput::make('name')
                            ->prefixIcon('lucide-user')
                            ->required(),
                        Forms\Components\Select::make('position')

                            ->options(collect(EmployeePositionEnum::cases())
                                ->mapWithKeys(fn($position) => [$position->value => $position->getLabel()])
                                ->toArray()
                            )
                            ->prefixIcon('lucide-briefcase-business')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->prefixIcon('lucide-mail'),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->prefixIcon('lucide-phone'),
                        
                        Forms\Components\Select::make('salary_type')
                            ->options(collect(SalaryTypeEnum::cases())
                                ->mapWithKeys(fn($type) => [$type->value => $type->getLabel()])
                                ->toArray()
                            )
                            ->prefixIcon('lucide-hand-coins')
                            ->required(),
                            
                        Forms\Components\TextInput::make('salary')
                            ->minValue(0)
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->prefixIcon('lucide-philippine-peso'),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_id')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->formatStateUsing(fn (string $state) => 
                        \App\Enums\EmployeePositionEnum::tryFrom($state)?->getLabel() ?? 'Unknown'
                    ),
                Tables\Columns\TextColumn::make('salary')->money('PHP'),
                Tables\Columns\TextColumn::make('salary_type')
                    ->badge(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DiscordTimeInsRelationManager::class,
            RelationManagers\ReimbursementsRelationManager::class,
            RelationManagers\PayslipRelationManager::class,
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
