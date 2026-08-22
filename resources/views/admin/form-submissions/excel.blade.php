<meta charset="UTF-8">

<table border="1">
    <thead>
        <tr>
            <th>Referensi</th>
            <th>Nama</th>
            <th>WhatsApp</th>
            <th>Email</th>
            <th>Event</th>
            <th>Kategori</th>
            <th>Status Pendaftaran</th>
            <th>Status Pembayaran</th>
            <th>Nominal</th>
            <th>Tanggal Submit</th>
        </tr>
    </thead>

    <tbody>

        @foreach($rows as $row)

            <tr>
                <td>{{ $row->reference_number }}</td>
                <td>{{ $row->submitter_name }}</td>
                <td>{{ $row->submitter_phone }}</td>
                <td>{{ $row->submitter_email }}</td>
                <td>{{ $row->form?->title }}</td>
                <td>{{ $row->form?->category }}</td>
                <td>{{ $row->registration_status }}</td>
                <td>{{ $row->payment_status }}</td>
                <td>{{ $row->payment_amount }}</td>
                <td>
                    {{ $row->submitted_at?->format('d M Y H:i') }}
                </td>
            </tr>

        @endforeach

    </tbody>
</table>
