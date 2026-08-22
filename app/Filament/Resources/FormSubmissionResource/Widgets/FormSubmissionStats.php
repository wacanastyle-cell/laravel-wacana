<?php

namespace App\Filament\Resources\FormSubmissionResource\Widgets;

use App\Models\Form;
use App\Models\FormSubmission;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FormSubmissionStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $total =
            FormSubmission::count();

        $accepted =
            FormSubmission::where(
                'registration_status',
                'accepted'
            )->count();

        $pending =
            FormSubmission::where(
                'registration_status',
                'pending'
            )->count();

        $rejected =
            FormSubmission::where(
                'registration_status',
                'rejected'
            )->count();

        $paid =
            FormSubmission::where(
                'payment_status',
                'paid'
            )->count();

        $unpaid =
            FormSubmission::where(
                'payment_status',
                'unpaid'
            )->count();

        $verification =
            FormSubmission::where(
                'payment_status',
                'verification'
            )->count();

        $money =
            FormSubmission::where(
                'payment_status',
                'paid'
            )
                ->sum(
                    'payment_amount'
                );

        $activeForms =
            Form::where(
                'status',
                'open'
            )->count();

        return [

            Stat::make(
                'Total Pendaftar',
                number_format($total)
            )
                ->description(
                    $activeForms .
                    ' form aktif'
                )
                ->icon(
                    'heroicon-o-users'
                ),

            Stat::make(
                'Diterima',
                number_format($accepted)
            )
                ->description(
                    'Menunggu: ' .
                    number_format($pending) .
                    ' • Ditolak: ' .
                    number_format($rejected)
                )
                ->icon(
                    'heroicon-o-check-circle'
                ),

            Stat::make(
                'Pembayaran Lunas',
                number_format($paid)
            )
                ->description(
                    'Belum bayar: ' .
                    number_format($unpaid) .
                    ' • Verifikasi: ' .
                    number_format($verification)
                )
                ->icon(
                    'heroicon-o-banknotes'
                ),

            Stat::make(
                'Total Uang Masuk',
                'Rp' .
                number_format(
                    (float) $money,
                    0,
                    ',',
                    '.'
                )
            )
                ->description(
                    'Hanya pembayaran berstatus Lunas'
                )
                ->icon(
                    'heroicon-o-currency-dollar'
                ),

        ];
    }
}
