<?php

namespace App\Filament\Widgets;

use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\Member;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $newSubmissions = FormSubmission::where('status', 'new')->count();

        return [
            Stat::make('Total Member', Member::count())
                ->description('Seluruh data member')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Formulir', Form::count())
                ->description('Formulir yang tersedia')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Total Submission', FormSubmission::count())
                ->description('Semua data yang masuk')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('info'),

            Stat::make('Submission Baru', $newSubmissions)
                ->description(
                    $newSubmissions > 0
                        ? 'Perlu diperiksa'
                        : 'Tidak ada submission baru'
                )
                ->descriptionIcon(
                    $newSubmissions > 0
                        ? 'heroicon-m-bell-alert'
                        : 'heroicon-m-check-circle'
                )
                ->color($newSubmissions > 0 ? 'danger' : 'success'),
        ];
    }
}
