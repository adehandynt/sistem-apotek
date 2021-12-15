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
		<h5>Data BPJS 
        </h5>
	</center>

    <div class="card-body">
        <h6 class="mt-0 mb-3 bg-light p-2">Laporan BPJS</h6>
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
                <th>No</th>
                <th>No BPJS</th>
                <th>No Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Total Pembelian</th>
                <th>Kasir</th>
            </tr>
        </thead>
        <tbody>
			@php $i=1;
            $disc=0;
            $grandtot=0;
            $temp_id="";
            @endphp
			@foreach($data as $p)
            @php 
            
            $disc+=$p->diskon;
            @endphp
			<tr>
                @if($p->no_transaksi != $temp_id)
                @php $temp_id=$p->no_transaksi;  
                $grandtot+=$p->total;@endphp
				<td>{{ $i++ }}</td>
                <td>{{$p->bpjs}}</td>
				<td>{{$p->no_transaksi}}</td>
				<td>{{$p->tgl_transaksi}}</td>
                <td>{{$p->nama_barang}}</td>
                <td>{{$p->jumlah }}</td>
				<td> Rp {{number_format($p->total,2)}}</td>
				<td>{{$p->nama_staf}}</td>
                @else
                <td></td>
				<td></td>
                <td></td>
				<td></td>
                <td>{{$p->nama_barang}}</td>
				<td>{{$p->jumlah }}</td>
                <td></td>
				<td></td>
				<td></td>
                @endif
			</tr>
			@endforeach
		</tbody>
	</table>
    <hr>
    <table class="float-right">
        <tr>
            <td><b>Total Piutang BPJS</b></td>
            <td>:</td>
            <td>Rp {{number_format($grandtot,2)}}</td>
        </tr>
    </table>

</body>
</html>