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
		<h5>Data Penjualan 
        </h5>
	</center>

    <div class="card-body">
        <h6 class="mt-0 mb-3 bg-light p-2">Laporan Penjualan</h6>
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

        </div>
        </div>
    </div>
    <hr>
    <table class="table table-centered table-nowrap mb-0" id="detail-datatables">
        <thead class="table-light">
            <tr>
                <th>NO</th>
                <th>NO Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Barang</th>
                {{-- <th>Harga</th> --}}
                <th>Jumlah</th>
                <th>Total Pembelian</th>
                <th>Kasir</th>
            </tr>
        </thead>
        <tbody>
			@php $i=1;
            $disc=0;
            $grandtot=0;
            $no_transaksi_temp="";
            @endphp
			@foreach($data as $p)
            @php 
            if($p->no_transaksi != $no_transaksi_temp){
              $grandtot+=$p->total;
            $disc+=$p->diskon;
            }
            $no_transaksi_temp=$p->no_transaksi;
            @endphp
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$p->no_transaksi}}</td>
				<td>{{$p->tgl_transaksi}}</td>
                <td>{{$p->nama_barang}}</td>
				{{-- <td> Rp {{number_format($p->total / $p->jumlah,2)}}</td> --}}
                <td>{{$p->jumlah }}</td>
				<td> Rp {{number_format($p->total,2)}}</td>
				<td>{{$p->nama_staf}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
    <hr>
    <table class="float-right">
        <tr>
            <td><b>Total Pendapatan Penjualan</b></td>
            <td>:</td>
            <td>Rp {{number_format($grandtot,2)}}</td>
        </tr>
    </table>

</body>
</html>