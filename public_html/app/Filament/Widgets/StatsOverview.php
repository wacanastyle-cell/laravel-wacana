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
        return [
            Stat::make('Total Anggota', Member::count())
                ->description('Jumlah member aktif dan non-aktif')
                ->color('success'),
            Stat::make('Total Galeri', Gallery::count())
                ->description('Album galeri yang tersedia')
                ->color('info'),
            Stat::make('Total Foto', GalleryPhoto::count())
                ->description('Jumlah foto dalam album')
                ->color('warning'),
            Stat::make('Total Formulir', Form::count())
                ->description('Semua formulir yang dibuat')
                ->color('primary'),
            Stat::make('Total Submission', FormSubmission::count())
                ->description('Semua data masuk dari formulir')
                ->color('danger'),
        ];
    }
}
