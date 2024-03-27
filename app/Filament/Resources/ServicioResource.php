<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicioResource\Pages;
use App\Filament\Resources\ServicioResource\RelationManagers;
use App\Models\Servicio;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ServicioResource extends Resource
{
    protected static ?string $model = Servicio::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $heading = 'Servicio';
    protected static ?int $navigationSort = 2;
    protected static  ?string $navigationGroup = 'Administrar';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Formulario Servicio')
                ->schema([
                    Forms\Components\Select::make('empresa_id')
                    ->relationship('empresa', 'nombre')
                    ->autofocus()
                    ->required(),
                    Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(70)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function(string $operation, $state,Forms\Set $set){
                        if ($operation !== 'create') {
                            return ;
                        }
                        $set('slug', Str::slug($state));
                    }),
                    Forms\Components\TextInput::make('precio')
                        ->required()
                        ->numeric(),
                        Forms\Components\TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->unique(Servicio::class, 'slug', ignoreRecord: true),
                    Forms\Components\Toggle::make('is_visible')
                        ->required(),

                ])->columns(2)
                
            ]);
    }

    public static function table(Table $table): Table
    {
 
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('empresa.nombre')
                        ->sortable()
                        ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('precio')
                    ->numeric()
                    ->sortable()
                    ->money('CLP', locale: 'es'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean(),
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
                    ->trueLabel('Servicios activos')
                    ->falseLabel('Servicios inactivos')
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
            ])
            ->emptyStateDescription(__('No hay Servicios registrados!'));
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
            'index' => Pages\ListServicios::route('/'),
            'create' => Pages\CreateServicio::route('/create'),
            'edit' => Pages\EditServicio::route('/{record}/edit'),
        ];
    }
}
