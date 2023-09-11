<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TraitementResource\Pages;
use App\Filament\Resources\TraitementResource\RelationManagers;
use App\Models\Cycle;
use App\Models\Infrastructure;
use App\Models\Traitement;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TraitementResource extends Resource
{
    protected static ?string $model = Traitement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Traitement')
                    ->schema([
                        Select::make('cycle_id')
                            ->relationship(
                                name: 'cycle',
                                titleAttribute: 'nom',
                            )
                            ->label('Nom du cycle')
                            ->live()
                            ->required(),
                        Fieldset::make('Traitement')
                            ->schema([
                                DatePicker::make('created_at')
                                    ->label('Date du traitement')
                                    ->required(),
                                TextInput::make('produit')
                                    ->required(),
                                TextInput::make('prix')
                            ])
                            ->columns(3)
                            ->disabled(fn(\Filament\Forms\Get $get) => is_null($get('cycle_id') ))
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cycle_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('produit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prix')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListTraitements::route('/'),
            'create' => Pages\CreateTraitement::route('/create'),
            'edit' => Pages\EditTraitement::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
