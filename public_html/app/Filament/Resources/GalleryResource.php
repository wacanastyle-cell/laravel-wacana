<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Konten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    TextInput::make('title')->required()->maxLength(255),
                    TextInput::make('slug')->maxLength(255)->nullable(),
                    DatePicker::make('event_date'),
                    Select::make('status')->options(['published' => 'Published', 'draft' => 'Draft'])->default('published'),
                    FileUpload::make('cover')->disk('public')->directory('galleries')->image()->columnSpanFull(),
                    Textarea::make('description')->rows(4)->columnSpanFull(),
                ]),
                Repeater::make('photos')
                    ->relationship('photos')
                    ->label('Foto Album')
                    ->schema([
                        FileUpload::make('image')->required()->disk('public')->directory('gallery-photos')->image(),
                        TextInput::make('caption')->maxLength(255),
                        TextInput::make('sort_order')->numeric()->default(0),
                    ])
                    ->columns(3)
                    ->reorderable(true)
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')->disk('public')->label('Cover')->size(60),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('event_date')->date('d M Y')->sortable(),
                TextColumn::make('status')->badge()->color(fn (string $state): string => $state === 'published' ? 'success' : 'warning'),
            ])
            ->filters([
                SelectFilter::make('status')->options(['published' => 'Published', 'draft' => 'Draft']),
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
            ->defaultSort('event_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGalleries::route('/'),
        ];
    }
}
