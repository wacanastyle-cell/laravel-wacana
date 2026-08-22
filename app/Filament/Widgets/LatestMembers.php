<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestMembers extends TableWidget
{
    protected static ?string $heading = 'Calon Member Terbaru';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Member::query()->latest('created_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('city')
                    ->label('Kota')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('motor_type')
                    ->label('Motor')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->copyable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktif',
                        'inactive' => 'Belum Aktif',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string =>
                        $state === 'active' ? 'success' : 'warning'
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Mendaftar')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(
                        fn (Member $record): string =>
                            route(
                                'filament.admin.resources.members.index'
                            )
                    ),
            ])
            ->paginated([5])
            ->defaultPaginationPageOption(5)
            ->emptyStateHeading('Belum ada calon member')
            ->emptyStateDescription(
                'Pendaftar baru akan muncul di sini.'
            )
            ->emptyStateIcon('heroicon-o-users');
    }
}
