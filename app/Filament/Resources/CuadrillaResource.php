<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CuadrillaResource\Pages;
use App\Filament\Resources\CuadrillaResource\RelationManagers;
use App\Models\Cuadrilla;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CuadrillaResource extends Resource
{
    protected static ?string $model = Cuadrilla::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Cuadrillas';
    protected static ?string $navigationGroup = 'Administrar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Formulario empresa')
                    ->schema([
                        TextInput::make('nombre')
                                 ->autofocus()
                                 ->required()
                                 ->minLength(2)
                                 ->maxLength(100)
                                 ->unique(static::getModel(), 'nombre', ignoreRecord: true)
                                 ->label(__('Nombre cuadrilla')),
                        MarkdownEditor::make('descripcion')->columnSpan('full'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                ->searchable()
                ->sortable()
                ->description(fn (Cuadrilla $cuadrilla) => $cuadrilla->descripcion)
            ])
            ->filters([
                //
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
            ])
            ->emptyStateDescription(__('No hay cuadrillas disponibles!'));
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
            'index' => Pages\ListCuadrillas::route('/'),
            'create' => Pages\CreateCuadrilla::route('/create'),
            'edit' => Pages\EditCuadrilla::route('/{record}/edit'),
        ];
    }
}
