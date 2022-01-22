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
<table class="table table-centered table-nowrap mb-0" id="detail-datatables">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>No Transaksi</th>
            <th>Tanggal Transaksi</th>
            <th>Nama Barang</th>
            <th>Jumlah Terjual</th>
            <th>Sisa</th>
            <th>Total Pembelian</th>
            <th>Kasir</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1;
        $disc=0;
        $grandtot=0;
        $jumlah_terjual=0;
        @endphp
        @foreach($data as $p)
        @php 
          $grandtot+=$p->total;
        $disc+=$p->diskon;
        $jumlah_terjual+=$p->jumlah;
        @endphp
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{$p->no_transaksi}}</td>
            <td>{{$p->tgl_transaksi}}</td>
            <td>{{$p->nama_barang}}</td>
            <td>{{$p->jumlah }}</td>
            <td> {{$p->sisa}}</td>
            <td> Rp {{number_format($p->total,2)}}</td>
            <td>{{$p->nama_staf}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<hr>
<table class="float-right">
    <tr>
        <td><b>Total Barang Terjual</b></td>
        <td>:</td>
        <td>{{number_format($jumlah_terjual)}}</td>
    </tr>
    <tr>
        <td><b>Total Pendapatan Penjualan</b></td>
        <td>:</td>
        <td style="width:100px">Rp {{number_format($grandtot,2)}}</td>
    </tr>
</table>

</body>
</html>