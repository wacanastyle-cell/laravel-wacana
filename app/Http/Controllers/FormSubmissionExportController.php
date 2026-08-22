<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;

class FormSubmissionExportController extends Controller
{
    protected function submissions()
    {
        return FormSubmission::query()
            ->with('form')
            ->orderByDesc('submitted_at')
            ->get();
    }

    public function csv()
    {
        $rows = $this->submissions();

        return response()->streamDownload(
            function () use ($rows) {

                $handle =
                    fopen(
                        'php://output',
                        'w'
                    );

                fprintf(
                    $handle,
                    chr(0xEF) .
                    chr(0xBB) .
                    chr(0xBF)
                );

                fputcsv(
                    $handle,
                    [
                        'Referensi',
                        'Nama',
                        'WhatsApp',
                        'Email',
                        'Form/Event',
                        'Kategori',
                        'Status Pendaftaran',
                        'Status Pembayaran',
                        'Nominal',
                        'Metode Pembayaran',
                        'Tanggal Submit',
                    ]
                );

                foreach ($rows as $row) {

                    fputcsv(
                        $handle,
                        [
                            $row
                                ->reference_number,

                            $row
                                ->submitter_name,

                            $row
                                ->submitter_phone,

                            $row
                                ->submitter_email,

                            $row
                                ->form?->title,

                            $row
                                ->form?->category,

                            $row
                                ->registration_status,

                            $row
                                ->payment_status,

                            $row
                                ->payment_amount,

                            $row
                                ->payment_method,

                            $row
                                ->submitted_at
                                ?->format(
                                    'Y-m-d H:i:s'
                                ),
                        ]
                    );
                }

                fclose($handle);
            },
            'pendaftar-wacana-style-' .
            now()->format('Ymd-His') .
            '.csv'
        );
    }


    public function excel()
    {
        $rows =
            $this->submissions();

        return response()
            ->view(
                'admin.form-submissions.excel',
                compact('rows')
            )
            ->header(
                'Content-Type',
                'application/vnd.ms-excel; charset=UTF-8'
            )
            ->header(
                'Content-Disposition',
                'attachment; filename="pendaftar-wacana-style-' .
                now()->format('Ymd-His') .
                '.xls"'
            );
    }


    public function printAll()
    {
        $rows =
            $this->submissions();

        return view(
            'admin.form-submissions.print',
            compact('rows')
        );
    }


    public function printOne(
        FormSubmission $submission
    ) {
        $submission->load('form');

        return view(
            'admin.form-submissions.print-one',
            compact('submission')
        );
    }
}
