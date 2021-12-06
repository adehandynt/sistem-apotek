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
		<h5>Data Pembelian 
        </h5>
	</center>

    <div class="card-body">
        <h6 class="mt-0 mb-3 bg-light p-2">Laporan Pembelian</h6>
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
        @if(count($data)<1)
        <div class="row">
            <div class="col-sm-12">
                <h6 class="mt-0 mb-3 bg-light p-2">VENDOR</h6>
                <div class="mb-3">
                    <p>PT. <b>{{ $data[0]->nama_supplier }}</b></p>
                </div>

            </div>

            </div>
            @endif
        </div>
    </div>
    <hr>
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
				<td>{{$p->id_order}}</td>
				<td>{{$p->nama_supplier}}</td>
				<td>{{$p->tgl_order}}</td>
				<td> Rp {{number_format($p->total,2)}}</td>
				<td>{{$p->nama_staf}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
    <hr>
    <table class="float-right">
        <tr>
            <td><b>Grand Total</b></td>
            <td>:</td>
            <td>Rp {{number_format($grandtot,2)}}</td>
        </tr>
    </table>

</body>
</html>