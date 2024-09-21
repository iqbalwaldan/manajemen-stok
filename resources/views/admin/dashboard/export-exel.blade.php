<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Keuntungan</th>
            <th>Iklan</th>
            <th>Jumlah Barang Keluar</th>
            <th>Laba Bersih</th>
        </tr>
    </thead>
    @php
        $previousMonth = null;
    @endphp

    @if ($report->isEmpty())
        <tr>
            <td colspan="5" class="text-center font-weight-normal">Data Kosong</td>
        </tr>
    @else
        @foreach ($report as $row)
            @php
                $currentMonth = date('F Y', strtotime($row->month));
            @endphp

            @if ($previousMonth !== $currentMonth)
                <tr>
                    <td colspan="5" align="center" style="color:white; background:black;">
                        {{ $currentMonth }}
                    </td>
                </tr>
                @php
                    $previousMonth = $currentMonth;
                @endphp
            @endif

            <tr>
                <td>{{ date('d/m/Y', strtotime($row->date)) }}</td>
                <td>{{ $row->profit }}</td>
                <td>{{ $row->ads }}</td>
                <td>{{ $row->total_stock_out }}</td>
                <td>{{ $row->total_profit }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="font-weight:bold">Total</td>
            <td colspan="1" style="font-weight:bold">{{ $stock_out }}</td>
            <td colspan="1" style="font-weight:bold">{{ $total_profit }}</td>
        </tr>
    @endif
</table>
