<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationMenuResource\Pages;
use App\Models\NavigationMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NavigationMenuResource extends Resource
{
    protected static ?string $model = NavigationMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $navigationLabel = 'Navigation Menus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Menu Information')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->label('Menu Label')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Beranda, Tentang, Produk'),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->disabled(),

                        Forms\Components\TextInput::make('href')
                            ->label('URL / Link')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., /, /about, https://example.com'),

                        Forms\Components\Select::make('type')
                            ->label('Link Type')
                            ->options([
                                'internal' => 'Internal (Website)',
                                'external' => 'External (Outside)',
                                'anchor' => 'Anchor (On Same Page)',
                            ])
                            ->required()
                            ->default('internal'),

                        Forms\Components\TextInput::make('icon')
                            ->label('Icon Class')
                            ->maxLength(255)
                            ->placeholder('e.g., fa-solid fa-home')
                            ->helperText('Font Awesome icon class'),
                    ])->columns(2),

                Forms\Components\Section::make('Organization')
                    ->schema([
                        Forms\Components\Select::make('parent_id')
                            ->label('Parent Menu')
                            ->relationship('parent', 'label')
                            ->placeholder('None (Top Level)')
                            ->helperText('Select a parent menu for dropdown/submenu'),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Smaller numbers appear first'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Show this menu on website'),
                    ])->columns(2),

                Forms\Components\Section::make('Additional')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->maxLength(1000)
                            ->rows(3)
                            ->placeholder('Optional description for admin reference'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')
                    ->label('Menu Label')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('href')
                    ->label('URL')
                    ->searchable()
                    ->limit(40)
                    ->copyable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'internal' => 'blue',
                            'external' => 'green',
                            'anchor' => 'purple',
                        };
                    }),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status'),
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
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigationMenus::route('/'),
            'create' => Pages\CreateNavigationMenu::route('/create'),
            'edit' => Pages\EditNavigationMenu::route('/{record}/edit'),
        ];
    }
}
