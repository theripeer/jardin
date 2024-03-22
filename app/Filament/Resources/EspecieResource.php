<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EspecieResource\Pages;
use App\Filament\Resources\EspecieResource\RelationManagers;
use App\Models\Especie;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class EspecieResource extends Resource
{
    protected static ?string $model = Especie::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';
    protected static ?string $heading = 'Especie';
    protected static ?int $navigationSort = 1;
    protected static  ?string $navigationGroup = 'Administrar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Formulario especie')
                ->schema([
                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function(string $operation, $state,Forms\Set $set){
                            if ($operation !== 'create') {
                                return ;
                            }
                            $set('slug', Str::slug($state));
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->unique(Especie::class, 'slug', ignoreRecord: true),
                    Forms\Components\Toggle::make('is_visible')
                        ->label('Activo')
                        ->helperText('Campo activo o inactivo')
                        ->default(true)
                        ->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_visible')
                    ->label('Activo')
                    ->boolean()
                    ->trueLabel('Contratos activos')
                    ->falseLabel('Contratos inactivos')
                    ->native(false)
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListEspecies::route('/'),
            'create' => Pages\CreateEspecie::route('/create'),
            'edit' => Pages\EditEspecie::route('/{record}/edit'),
        ];
    }
}
