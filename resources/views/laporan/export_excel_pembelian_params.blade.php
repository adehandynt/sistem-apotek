<table class="float-right">
    <tr>
        <td colspan="5">
            <p><b>PT ADELIN BERKAH MEDIKA</b><br>
                <b>APOTEK SINDANGSARI FARMA</b>
                <br>Jalan Sindangsari 1<br>
                Antapani Bandung</p>
        </td>
    </tr>
</table>

<table class="float-right">
    @if(count($data)<1)
        <tr>
            <td>VENDOR</td>
            <td>:</td>
            <td>PT. <b>{{ $order[0]->nama_supplier }} </b></td>
        </tr>
    @endif

</table>


<table class="table table-centered table-nowrap mb-0" id="detail-datatables">
    <thead class="table-light">
        <tr>
            <th>NO</th>
            <th>ID PO</th>
            <th>Nama Supplier</th>
            <th>Tanggal Pembelian</th>
            <th>Total Pembelian</th>
            <th>Pengaju</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1;
            $disc=0;
            $grandtot=0;
        @endphp
        @foreach($data as $p)
            @php
                $grandtot+=$p->total;
                $disc+=$p->diskon;
            @endphp
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $p->id_order }}</td>
                <td>{{ $p->nama_supplier }}</td>
                <td>{{ $p->tgl_order }}</td>
                <td>{{ $p->total }}</td>
                <td>{{ $p->nama_staf }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table class="float-right">
    <tr>
        <td><b>Grand Total</b></td>
        <td>:</td>
        <td>Rp {{ number_format($grandtot,2) }}</td>
    </tr>
</table>