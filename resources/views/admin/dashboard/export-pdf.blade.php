<h2 style="text-align: center">REPORT</h2>
<table style="width:100%">
    <thead>
        <tr>
            <th style="width: 15%">Tanggal</th>
            <th style="width: 20%">Keuntungan</th>
            <th style="width: 20%">Iklan</th>
            <th style="width: 25%">Jumlah Barang Keluar</th>
            <th style="width: 20%">Laba Bersih</th>
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
                <td style="text-align: left">{{ date('d/m/Y', strtotime($row->date)) }}</td>
                <td style="text-align: right">Rp{{ number_format($row->profit, 0, ',', '.') }}</td>
                <td style="text-align: right">Rp{{ number_format($row->ads, 0, ',', '.') }}</td>
                <td style="text-align: right">{{ $row->total_stock_out }}</td>
                <td style="text-align: right">Rp{{ number_format($row->total_profit, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="font-weight:bold;">Total</td>
            <td colspan="1" style="font-weight:bold; text-align: right">{{ $stock_out }}</td>
            <td colspan="1" style="font-weight:bold; text-align: right">Rp{{ number_format($total_profit, 0, ',', '.') }}</td>
        </tr>
    @endif
</table>
