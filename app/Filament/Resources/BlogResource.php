<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dasar')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, $state) {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Dipublikasikan',
                            ])
                            ->default('draft')
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi'),
                    ])->columns(2),

                Section::make('Konten')
                    ->schema([
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->rows(3),
                        Textarea::make('content')
                            ->label('Konten HTML')
                            ->helperText('Tulis atau paste kode HTML artikel secara langsung. HTML akan disimpan sebagai source code dan dirender di halaman blog.')
                            ->required()
                            ->rows(35)
                            ->columnSpanFull()
                            ->extraAttributes([
                                'style' => 'font-family: monospace; font-size: 13px; line-height: 1.6; min-height: 700px;',
                                'spellcheck' => 'false',
                            ]),
                    ]),

                Section::make('Media')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Gambar Unggulan')
                            ->image()
                            ->disk('public')
                            ->directory('blog'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                    }),
                TextColumn::make('published_at')
                    ->label('Dipublikasikan')
                    ->dateTime('d M Y')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Penulis'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Dipublikasikan',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
