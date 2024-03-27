<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdenResource\Pages;
use App\Filament\Resources\OrdenResource\RelationManagers;
use App\Models\Orden;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FormNote;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\Card;

class OrdenResource extends Resource
{
    protected static ?string $model = Orden::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 0;
    protected static ?string $navigationLabel = 'Ordenes';
    protected static ?string $navigationGroup = 'Tareas';

    public static function form(Form $form): Form
    {
        $estados = [
            'creada' => 'CREADA',
            'en proceso' => 'EN PROCESO',
            'rechazada' => 'RECHAZADA',
            'realizada' => 'REALIZADA'
        ];
        $pagos = [
            'por pagar' => 'POR PAGAR',
            'pagado' => 'PAGADO'
        ];

        return $form
            ->schema([
                Section::make('Formulario Servicio')
                ->schema([
                    TextInput::make('folio')
                        ->autofocus()
                        ->required()
                        ->minLength(13) // Mínimo de caracteres para cumplir con el patrón
                        ->maxLength(13) // Máximo de caracteres para cumplir con el patrón
                        ->unique(static::getModel(), 'folio', ignoreRecord: true)
                        ->label(__('Numero de folio'))
                        ->extraAttributes(['pattern' => '[A-Za-z0-9]{6}-[A-Za-z0-9]{6}'])
                        ->hint(__('requerido: ABC123-XYZ789')),
                    TextInput::make('direccion'),
                    Forms\Components\Select::make('especie_id')
                        ->relationship('especie', 'nombre')
                        ->required()
                        ->searchable(),
                        //->columns(1),
                    Forms\Components\Select::make('servicio_id')
                        ->relationship('servicio', 'nombre')
                        ->required()
                        ->searchable(),
                        //->columns(1),
                    TextInput::make('plazos'),
                    Forms\Components\Select::make('cuadrilla_id')
                        ->relationship('cuadrilla', 'nombre')
                        ->required()
                        ->searchable(),
                        //->columns(1),
                    Forms\Components\FileUpload::make('image1')
                        ->label(__('Imagen 1'))
                        ->image()
                        ->maxSize(4096)
                        ->placeholder(__('Imagen de trabajo'))
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('image2')
                        ->label(__('Imagen 2'))
                        ->image()
                        ->maxSize(4096)
                        ->placeholder(__('Imagen de trabajo'))
                        ->columnSpanFull(),
                    /*Forms\Components\Select::make('estados')
                        ->options(fn () => collect($estados)->map(fn ($label, $value) => [
                            'value' => $value,
                        ]))
                        ->label(__('Estado')),
                    Forms\Components\Select::make('estpago')
                        ->options(fn () => collect($pagos)->map(fn ($label, $value) => [
                            'value' => $value,
                        ]))
                        ->label(__('Estado Pago')),*/
                    MarkdownEditor::make('observacion')
                        ->columnSpan('full')
                        ->label(__('Comentarios')),

                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('folio')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('especie.nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->searchable()
                    ->date('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->searchable()
                    ->date('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('plazos'),
                Tables\Columns\TextColumn::make('estados')
                    ->sortable()
                    ->searchable()
                    ->label(__('Estado')),
                Tables\Columns\TextColumn::make('estpago')
                    ->sortable()
                    ->searchable()
                    ->label(__('Estado pago')),
                Tables\Columns\TextColumn::make('cuadrilla.nombre')
                        ->sortable()
                        ->searchable(),
            ])
            ->filters([
                SelectFilter::make('cuadrilla_id')
                    ->relationship('cuadrilla', 'nombre')
                    ->label(__('Cuadrillas'))
                    
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
            ->emptyStateDescription(__('No se encontraron trabajos asociados!'));
    }

    /*
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            ImageEntry::make('image1')
                ->width(320)
                ->hiddenLabel(),
            Section::make('Formulario Servicio')
            
        ]);
    }*/
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Card::make('Trabajo') // Use the base Card component
                ->schema([
                    ImageEntry::make('image1')
                        ->label('Imagen 1'),
                    ImageEntry::make('image2')
                        ->label('Imagen 2'),
                    
            ])->columns(3),
            Card::make()->schema([
                TextEntry::make('folio')
                    ->label(__('N° de Folio')),
                TextEntry::make('direccion')
                    ->label(__('Dirección')),
                TextEntry::make('fitosanitario')
                    ->label(__('Fitosanitario'))
            ])->columns(2)
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
            'index' => Pages\ListOrdens::route('/'),
            'create' => Pages\CreateOrden::route('/create'),
            'edit' => Pages\EditOrden::route('/{record}/edit'),
        ];
    }
}
