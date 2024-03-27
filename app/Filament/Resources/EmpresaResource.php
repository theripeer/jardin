<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmpresaResource\Pages;
use App\Filament\Resources\EmpresaResource\RelationManagers;
use App\Models\Empresa;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class EmpresaResource extends Resource
{
    protected static ?string $model = Empresa::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Empresas';
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
                                 ->live(onBlur: true)
                                 ->afterStateUpdated(function(string $operation, $state,Forms\Set $set){
                                        if ($operation !== 'create') {
                                            return ;
                                        }

                                        $set('slug', Str::slug($state));
                                 }),
                        TextInput::make('slug')
                                 ->disabled()
                                 ->dehydrated()
                                 ->required()
                                 ->unique(Empresa::class, 'slug', ignoreRecord: true),
                        TextInput::make('r_social')
                                 ->required(),
                        TextInput::make('rut')
                                 ->required()
                                 ->live(onBlur: true)
                                 //->rules('regex:/^\d{1,6}(\.\d{0,2})?$/')
                                 ->unique(),
                        MarkdownEditor::make('descripcion')->columnSpan('full'),
                        Toggle::make('is_visible')
                                 ->label('Activo')
                                 ->helperText('Campo activo o inactivo')
                                 ->default(true)
                                 ->required()
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('r_social')
                    ->searchable(),
                TextColumn::make('rut')
                    ->searchable(),
                IconColumn::make('is_visible')->boolean()
                    ->label('Activo'),
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
            ])
            ->emptyStateDescription(__('No hay Empresas para mostrar en este momento!'));
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
            'index' => Pages\ListEmpresas::route('/'),
            'create' => Pages\CreateEmpresa::route('/create'),
            'edit' => Pages\EditEmpresa::route('/{record}/edit'),
        ];
    }
}
