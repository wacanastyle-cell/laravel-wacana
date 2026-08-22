<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>
        {{ $submission->reference_number }}
    </title>

    <style>
        body {
            max-width: 850px;
            margin: 30px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            color: #111;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th,
        td {
            border: 1px solid #bbb;
            padding: 9px;
            text-align: left;
            vertical-align: top;
        }

        th {
            width: 35%;
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

<h1>
    {{ $submission->reference_number }}
</h1>

<p>
    {{ $submission->form?->title }}
</p>

<table>

    <tr>
        <th>Nama</th>
        <td>
            {{ $submission->submitter_name }}
        </td>
    </tr>

    <tr>
        <th>WhatsApp</th>
        <td>
            {{ $submission->submitter_phone }}
        </td>
    </tr>

    <tr>
        <th>Email</th>
        <td>
            {{ $submission->submitter_email ?: '-' }}
        </td>
    </tr>

    <tr>
        <th>Status Pendaftaran</th>
        <td>
            {{ $submission->registration_status }}
        </td>
    </tr>

    <tr>
        <th>Status Pembayaran</th>
        <td>
            {{ $submission->payment_status }}
        </td>
    </tr>

    <tr>
        <th>Nominal</th>
        <td>
            Rp{{ number_format(
                (float) $submission->payment_amount,
                0,
                ',',
                '.'
            ) }}
        </td>
    </tr>

    @foreach(
        ($submission->data ?? [])
        as $key => $value
    )

        <tr>
            <th>
                {{ str_replace(
                    '_',
                    ' ',
                    ucfirst($key)
                ) }}
            </th>

            <td>
                @if(is_array($value))
                    {{ implode(', ', $value) }}
                @else
                    {{ $value }}
                @endif
            </td>
        </tr>

    @endforeach

</table>

</body>
</html>
