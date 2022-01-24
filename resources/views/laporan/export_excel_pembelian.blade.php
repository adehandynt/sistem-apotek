
    <table class="float-right">
        <tr>
            <td colspan="5"> <p><b>PT ADELIN BERKAH MEDIKA</b><br>
                <b>APOTEK SINDANGSARI FARMA</b>
            <br>Jalan Sindangsari 1<br>
            Antapani Bandung</p></td>
        </tr>
        <tr>
            <td> 
                    <p>Nomor Dokumen PO</p>
                </td>
                <td>:</td>
                <td><b>{{ $order[0]->id_order }}</b></td>
        </tr>
        <tr>
            <td> 
                <p>Tanggal</p>
            </td>
            <td>:</td>
            <td> <b>{{ $order[0]->tgl_order }}</b></td>
        </tr>
    </table>

    <table class="float-right">
        <tr>
            <td>VENDOR</td>
            <td>:</td>
            <td>PT. <b>{{ $order[0]->nama_supplier }} </b></td>
        </tr>
        <tr>
            <td>SHIP TO</td>
            <td>:</td>
            <td><p><b>APOTEK SINDANGSARI FARMA</b><br>
                Jalan Sindangsari 1<br>
                    Antapani Wetan Bandung</p></td>
        </tr>
    </table>

<table class="table table-centered table-nowrap mb-0" id="detail-datatables">
    <thead class="table-light">
        <tr>
            <th>NO</th>
            <th>ITEM</th>
            <th>DESCRIPTIONS</th>
            <th>QTY</th>
            <th>UOM</th>
            <th>UNIT PRICE</th>
            <th>DISC (%)</th>
            <th>TOTAL (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1;
        $disc=0;
        @endphp
        @foreach($data as $p)
        @php 
        $disc+=$p->diskon;
        @endphp
        <tr>
            <td>{{ $i++ }}</td>
            <td></td>
            <td>{{$p->kode_barang.' - '.$p->nama_barang}}</td>
            <td>{{$p->jumlah}}</td>
            <td>{{$p->satuan}}</td>
            <td> {{$p->harga_beli}}</td>
            <td>{{$p->diskon}} %</td>
            <td>  {{$p->total,2}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<table class="float-right">
    <tr>
        <td><b>Sub Total</b></td>
        <td>:</td>
        <td>Rp {{number_format($order[0]->total-($order[0]->total*0.1),2)}}</td>
    </tr>
    <tr>
        <td><b>Tax</b></td>
        <td>:</td>
        <td>Rp {{number_format($order[0]->total*0.1,2)}}</td>
    </tr>
    <tr>
        <td><b>Grand Total</b></td>
        <td>:</td>
        <td>Rp {{number_format($order[0]->total,2)}}</td>
    </tr>
</table>