<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Models\AboutSection;
use App\Models\AboutImageHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    
    protected static ?string $navigationLabel = 'Acerca de la Empresa';
    
    protected static ?string $modelLabel = 'Acerca de';
    
    protected static ?string $pluralModelLabel = 'Acerca de la Empresa';
    
    protected static ?string $navigationGroup = 'Contenido del Sitio';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $recentImages = AboutImageHistory::getRecent();
        
        return $form
            ->schema([
                Section::make('Imagen Principal')
                    ->description('Imagen que aparece en la sección "Acerca de la Empresa"')
                    ->schema([
                        Forms\Components\FileUpload::make('current_image')
                            ->label('Imagen Actual')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->directory('about')
                            ->visibility('public')
                            ->required()
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    AboutImageHistory::addToHistory($state);
                                }
                            }),
                    ]),
                    
                Section::make('Historial de Imágenes')
                    ->description('Últimas 5 imágenes utilizadas - Haz clic en una para reutilizarla')
                    ->schema([
                        Forms\Components\CheckboxList::make('image_history')
                            ->label(false)
                            ->options($recentImages->pluck('image_path', 'image_path')->toArray())
                            ->descriptions($recentImages->mapWithKeys(function ($item) {
                                return [$item->image_path => 'Usada el ' . $item->used_at->format('d/m/Y H:i')];
                            })->toArray())
                            ->columns(5)
                            ->disabled()
                            ->dehydrated(false),
                            
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('use_history_image')
                                ->label('Usar imagen del historial')
                                ->icon('heroicon-o-arrow-path')
                                ->color('info')
                                ->form([
                                    Forms\Components\Select::make('selected_image')
                                        ->label('Selecciona una imagen')
                                        ->options($recentImages->pluck('image_path', 'image_path')->toArray())
                                        ->required(),
                                ])
                                ->action(function (array $data, $set, $record) {
                                    $set('current_image', $data['selected_image']);
                                    $record->current_image = $data['selected_image'];
                                    $record->save();
                                }),
                        ])->hidden(fn () => $recentImages->isEmpty()),
                    ])
                    ->collapsible()
                    ->collapsed(false),
                
                Section::make('Contenido de Texto')
                    ->schema([
                        Forms\Components\Textarea::make('title')
                            ->label('Título')
                            ->rows(2)
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('description')
                            ->label('Descripción')
                            ->rows(4)
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('highlighted_text')
                            ->label('Texto Destacado')
                            ->helperText('Este texto aparecerá resaltado en la página')
                            ->rows(3)
                            ->columnSpanFull(),
                            
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('years_experience')
                                    ->label('Años de Experiencia')
                                    ->numeric()
                                    ->default(12)
                                    ->required(),
                                    
                                Forms\Components\TextInput::make('happy_clients')
                                    ->label('Clientes Satisfechos')
                                    ->numeric()
                                    ->default(100)
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('current_image')
                    ->label('Imagen Actual')
                    ->size(100),
                    
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->limit(50)
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('years_experience')
                    ->label('Años Experiencia')
                    ->badge()
                    ->color('success'),
                    
                Tables\Columns\TextColumn::make('happy_clients')
                    ->label('Clientes')
                    ->badge()
                    ->color('info'),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Actualización')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Deshabilitar eliminación masiva para evitar borrar el registro único
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutSections::route('/'),
            'edit' => Pages\EditAboutSection::route('/{record}/edit'),
        ];
    }
    
    // Solo permitir un registro
    public static function canCreate(): bool
    {
        return AboutSection::count() === 0;
    }
}
