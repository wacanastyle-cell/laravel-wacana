<?php

namespace App\Filament\Widgets;

use App\Models\FormSubmission;
use App\Models\Member;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestAdminActivity extends TableWidget
{
    protected static ?string $heading = 'Notifikasi & Aktivitas Terbaru';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FormSubmission::query()
                    ->with('form')
                    ->latest('submitted_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('reference_number')
                    ->label('Referensi')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('submitter_name')
                    ->label('Pengirim')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('form.title')
                    ->label('Formulir')
                    ->searchable()
                    ->limit(35),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new' => 'Baru',
                        'processing' => 'Diproses',
                        'confirmed' => 'Dikonfirmasi',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        'rejected' => 'Ditolak',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'processing' => 'warning',
                        'confirmed', 'completed' => 'success',
                        'cancelled', 'rejected' => 'gray',
                        default => 'info',
                    }),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(
                        fn (FormSubmission $record): string =>
                            route(
                                'filament.admin.resources.form-submissions.index',
                                ['record' => $record]
                            )
                    ),
            ])
            ->paginated([5, 10])
            ->defaultPaginationPageOption(5)
            ->emptyStateHeading('Belum ada submission')
            ->emptyStateDescription(
                'Submission dari formulir website akan muncul di sini.'
            )
            ->emptyStateIcon('heroicon-o-inbox');
    }
}
