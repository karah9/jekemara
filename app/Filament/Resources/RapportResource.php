<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RapportResource\Pages;
use App\Filament\Resources\RapportResource\RelationManagers;

use App\Models\Infrastructure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RapportResource extends Resource
{

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longueur')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('largeur')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('diametre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('profondeur')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('niveau')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('superficie')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('volume')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn(Model $record) => route('filament.admin.pages.rapport-cycle', ['infrastructure_id' => $record])),

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
            'index' => Pages\ListRapports::route('/'),
            //'create' => Pages\CreateRapport::route('/create'),
            'view' => Pages\ViewRapport::route('/{record}'),
            'edit' => Pages\EditRapport::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return Infrastructure::query();
    }
}
