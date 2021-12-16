<!DOCTYPE html>
<html>
<head>
	<title>Export File</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
    p{
        font-size: 12px;
    }
</style>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
    
	<center>
		<h5>PURCHASE ORDER
        </h5>
	</center>

    <div class="card-body">
        <h6 class="mt-0 mb-3 bg-light p-2">Detail Pembelian</h6>
        <div class="row">
            <div class="col-sm-12">
                <div>
                    <p><b>PT ADELIN BERKAH MEDIKA</b><br>
                        <b>APOTEK SINDANGSARI FARMA</b>
                    <br>Jalan Sindangsari 1<br>
                    Antapani Bandung</p>
                </div>
                <div>
                    <p>SIPA : <b></b></p>
                </div>

                <div>
                    <p>SIA : <b></b></p>
                </div>

            </div>
 
            <div class="col-sm-12">
                <div class="text-right mb-1">
                    <p>Nomor Dokumen PO : <b>{{ $order[0]->id_order }}</b></p>
                </div>
                <div class="text-right mb-1">
                    <p>Tanggal : <b>{{ $order[0]->tgl_order }}</b></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-3 p-2" style="background-color:rgb(183, 211, 183)">
                    <p><b> VENDOR </b></p></div>
                <div class="mb-3">
                    <p>PT. <b>{{ $order[0]->nama_supplier }}</b></p>
                </div>

            </div>
 
            <div class="col-sm-12">
                <div class="text-right mb-3 p-2">
                    <p> <b>SHIP TO</b> </p></div>
                    <div class="text-right mb-3">
                        <p><b>APOTEK SINDANGSARI FARMA</b><br>
                    Jalan Sindangsari 1<br>
                        Antapani Wetan Bandung</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <hr>
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
				<td> Rp {{number_format($p->harga_beli,2)}}</td>
				<td>{{$p->diskon}} %</td>
                <td> Rp {{number_format($p->total,2)}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
    <hr>
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

</body>
</html>