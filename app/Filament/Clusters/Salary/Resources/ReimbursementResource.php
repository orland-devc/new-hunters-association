<?php

namespace App\Filament\Clusters\Salary\Resources;

use App\Enums\ReimbursementStatusEnum;
use App\Filament\Clusters\Salary;
use App\Filament\Clusters\Salary\Resources\ReimbursementResource\Pages;
use App\Filament\Clusters\Salary\Resources\ReimbursementResource\RelationManagers;
use App\Models\Employee;
use App\Models\Reimbursement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Support\Segment;

class ReimbursementResource extends Resource
{
    protected static ?string $model = Reimbursement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Salary::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Reimbursement Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('reimbursement_code')
                            ->label('Reimbursement Code')
                            ->formatStateUsing(function ($state) {
                                return $state ? Segment::toDisplay($state) : Segment::of(Reimbursement::class)
                                    ->generate()
                                    ->display();
                            })
                            ->readOnly()
                            ->required()
                            ->prefixIcon('lucide-lock'),

                        Forms\Components\Select::make('employee_id')
                            ->label('Employee Code')
                            ->options(Employee::all()->mapWithKeys(function ($employee) {
                                return [$employee->id => "{$employee->employee_id} ({$employee->name})"];
                            }))
                            ->searchable()
                            ->preload()
                            ->required(),
                        

                        Forms\Components\Textarea::make('purpose')
                            ->required()
                            ->rows(3),

                        Forms\Components\FileUpload::make('receipt')
                            ->label('Receipt')
                            ->directory('receipts')
                            ->image()
                            ->nullable(),

                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->prefix('₱')
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->options(array_combine(
                                array_map(fn ($status) => $status->value, ReimbursementStatusEnum::cases()),
                                array_map(fn ($status) => $status->getLabel(), ReimbursementStatusEnum::cases())
                            ))
                            ->default(ReimbursementStatusEnum::PENDING->value)
                            ->required(),

                        Forms\Components\DatePicker::make('requested_at')
                            ->default(now())
                            ->required(),

                        Forms\Components\DatePicker::make('approved_at')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.employee_id')
                    ->label('Employee Code')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->money('PHP'),

                Tables\Columns\TextColumn::make('purpose')
                    ->limit(50),

                Tables\Columns\TextColumn::make('status')
                    ->badge(),

                Tables\Columns\TextColumn::make('requested_at')
                    ->date(),

                Tables\Columns\TextColumn::make('approved_at')
                    ->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(array_combine(
                        array_map(fn ($status) => $status->value, ReimbursementStatusEnum::cases()),
                        array_map(fn ($status) => $status->getLabel(), ReimbursementStatusEnum::cases())
                    )),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReimbursements::route('/'),
            'create' => Pages\CreateReimbursement::route('/create'),
            'edit' => Pages\EditReimbursement::route('/{record}/edit'),
        ];
    }
}
