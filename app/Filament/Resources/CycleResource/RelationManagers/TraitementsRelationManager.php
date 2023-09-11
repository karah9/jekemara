<?php

namespace App\Filament\Resources\CycleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TraitementsRelationManager extends RelationManager
{
    protected static string $relationship = 'traitements';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('produit')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('prix')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('created_at')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('produit')
            ->columns([
                Tables\Columns\TextColumn::make('produit'),
                Tables\Columns\TextColumn::make('prix'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
