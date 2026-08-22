<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pendaftar Wacana Style</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111;
            font-size: 12px;
        }

        h1 {
            margin-bottom: 5px;
        }

        .date {
            margin-bottom: 25px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #bbb;
            padding: 7px;
            vertical-align: top;
        }

        th {
            background: #eee;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button
        class="no-print"
        onclick="window.print()"
    >
        Print
    </button>

    <h1>Data Pendaftar Wacana Style</h1>

    <div class="date">
        Dicetak: {{ now()->format('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Ref</th>
                <th>Nama</th>
                <th>WhatsApp</th>
                <th>Event</th>
                <th>Pendaftaran</th>
                <th>Pembayaran</th>
                <th>Nominal</th>
            </tr>
        </thead>

        <tbody>

            @foreach($rows as $row)

                <tr>
                    <td>
                        {{ $row->reference_number }}
                    </td>

                    <td>
                        {{ $row->submitter_name }}
                    </td>

                    <td>
                        {{ $row->submitter_phone }}
                    </td>

                    <td>
                        {{ $row->form?->title }}
                    </td>

                    <td>
                        {{ $row->registration_status }}
                    </td>

                    <td>
                        {{ $row->payment_status }}
                    </td>

                    <td>
                        Rp{{ number_format(
                            (float) $row->payment_amount,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>

</body>
</html>
