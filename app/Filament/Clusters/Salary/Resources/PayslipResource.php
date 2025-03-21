<?php

namespace App\Filament\Clusters\Salary\Resources;

use App\Filament\Clusters\Salary;
use App\Filament\Clusters\Salary\Resources\PayslipResource\Pages;
use App\Filament\Clusters\Salary\Resources\PayslipResource\RelationManagers;
use App\Models\Payslip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Employee;

class PayslipResource extends Resource
{
    protected static ?string $model = Payslip::class;

    protected static ?string $navigationIcon = 'lucide-receipt';

    protected static ?string $cluster = Salary::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payslip Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('employee_id')
                            ->label('Employee Code')
                            ->options(Employee::all()->mapWithKeys(function ($employee) {
                                return [$employee->id => "{$employee->employee_id} ({$employee->name})"];
                            }))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('lucide-square-user-round'),

                        Forms\Components\TextInput::make('total_days')
                            ->readOnly()
                            ->label('Total Days')
                            ->prefixIcon('lucide-calendar-check-2')
                            ->formatStateUsing(fn ($state) => "{$state} days (" . ($state * 8) . " hours)"),

                        Forms\Components\TextInput::make('gross_pay')
                            ->readOnly()
                            ->default(0)
                            ->prefixIcon('lucide-philippine-peso')
                            ->label('Gross Pay'),

                        Forms\Components\TextInput::make('ot_hours')
                            ->readOnly()
                            ->label('Overtime')
                            ->prefixIcon('lucide-clock-4')
                            ->formatStateUsing(fn ($state) => "{$state} hours"),

                        Forms\Components\TextInput::make('overtime_pay')
                            ->readOnly()
                            ->label('OT Pay')
                            ->prefixIcon('lucide-philippine-peso'),

                        Forms\Components\TextInput::make('deductions')
                            ->default(0)
                            ->minValue(0)
                            ->numeric() 
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $set('net_pay', $get('gross_pay') - $state);
                            })
                            ->prefixIcon('lucide-philippine-peso'),

                        Forms\Components\TextInput::make('reimbursements')
                            ->default(0)
                            ->numeric()
                            ->prefixIcon('lucide-philippine-peso'),

                        Forms\Components\TextInput::make('professional_fee')
                            ->default(0)
                            ->numeric()
                            ->prefixIcon('lucide-philippine-peso')
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $set('net_pay', $get('gross_pay') + $get('overtime_pay') + $state - $get('deductions'));
                            }),

                        Forms\Components\TextInput::make('net_pay')
                            ->readOnly()
                            ->default(0)
                            ->prefixIcon('lucide-philippine-peso'),

                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                            ])
                            ->default('pending')
                            ->required(),
                            ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.employee_id')->sortable(),
                Tables\Columns\TextColumn::make('total_hours')
                ->getStateUsing(function ($record) {
                    $totalMinutes = $record->employee->discordTimeIns()
                        ->whereNotNull('time_out') 
                        ->whereBetween('time_in', [$record->payroll->start_date, $record->payroll->end_date])
                        ->get()
                        ->sum(function ($timeInRecord) {
                            $timeIn = new \Carbon\Carbon($timeInRecord->time_in);
                            $timeOut = new \Carbon\Carbon($timeInRecord->time_out);
            
                            return $timeIn->diffInMinutes($timeOut); 
                        });
            
                    $totalHours = floor($totalMinutes / 60);
                    $remainingMinutes = $totalMinutes % 60;
            
                    $fullDays = floor($totalHours / 8);
                    $remainingHours = $totalHours % 8;
            
                    $dayEquivalent = $fullDays; 
                    if ($remainingHours >= 4) {
                        $dayEquivalent += 0.5; 
                    }
            
                    return "{$totalHours}h {$remainingMinutes}m ({$dayEquivalent} days)";
                })
                ->sortable()
                ->label('Total Hours'),                            Tables\Columns\TextColumn::make('gross_pay')->money('PHP'),
                Tables\Columns\TextColumn::make('deductions')->money('PHP'),
                Tables\Columns\TextColumn::make('net_pay')->money('PHP'),
                Tables\Columns\TextColumn::make('payment_status')
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
            'index' => Pages\ListPayslips::route('/'),
            'edit' => Pages\EditPayslip::route('/{record}/edit'),
        ];
    }
}
