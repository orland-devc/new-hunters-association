<?php

namespace App\Filament\Clusters\Salary\Resources\EmployeeResource\RelationManagers;

use App\Filament\Clusters\Salary\Resources\ReimbursementResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReimbursementsRelationManager extends RelationManager
{
    protected static string $relationship = 'reimbursements';

    public function form(Form $form): Form
    {
        return ReimbursementResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('employee_id')
            ->columns([
                Tables\Columns\TextColumn::make('reimbursement_code')
                    ->label('Code')
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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
