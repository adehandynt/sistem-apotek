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
		<h5>RETUR PEMBELIAN
        </h5>
	</center>

    <div class="card-body">
        <h6 class="mt-0 mb-3 bg-light p-2"><b>PEMBELI</b></h6>
        <div class="row">
            <div class="col-sm-12">
                <div>
                    <p><b>PT ADELIN BERKAH MEDIKA</b><br>
                        <b>APOTEK SINDANGSARI FARMA</b>
                    <br>Jalan Sindangsari 1<br>
                    Antapani Bandung</p>
                </div>
            </div>
        </div>

        <h6 class="mt-0 mb-3 bg-light p-2"><b>KEPADA PENJUAL</b></h6>
        <div class="row">
            <div class="col-sm-12">
                <div>
                    <p><b>PT {{ $detail[0]->nama_supplier }}</b>
                    <br>{{ $detail[0]->alamat }}</p>
                </div>
            </div>
        </div>
        </div>
    </div>
    <hr>
    <div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <div>
                <p><b>Tanggal Retur :</b> {{$data[0]->tgl_retur}}</p>
            </div>
        </div>
    </div>
</div>
    <hr>
    <table class="table table-centered table-nowrap mb-0" id="detail-datatables">
        <thead class="table-light">
            <tr>
                <th>NO</th>
                <th>NAMA BARANG</th>
                <th>UNIT</th>
                <th>UOM</th>
                <th>UNIT PRICE</th>
                <th>DISC (%)</th>
                <th>TOTAL (Rp)</th>
                <th>EXP DATE</th>
                <th>DESC</th>
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
				<td>{{$p->nama_barang}}</td>
				<td>{{$p->jumlah}}</td>
				<td>{{$p->satuan}}</td>
				<td> Rp {{number_format($p->harga_beli,2)}}</td>
				<td>{{$p->diskon}} %</td>
                <td> Rp {{number_format($p->total,2)}}</td>
                <td> {{$p->tgl_exp}}</td>
                <td> {{$p->deskripsi}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
    <hr>
    <div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <div>
                <div class="col-sm-2 text-center">
                <span><p><b>Pembeli</b></p></span></div>
                <br><br><br><p>
                (.......................................)
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>