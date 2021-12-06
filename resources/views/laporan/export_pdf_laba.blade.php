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
		<h5>Data Laba Rugi 
        </h5>
	</center>

    <div class="card-body">
        <h6 class="mt-0 mb-3 bg-light p-2">Laporan Laba Rugi ( {{$tanggal}} )</h6>
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
    @php
     $total_masuk = ($data[0]->penjualan_barang+$data[0]->piutang_obat+$data[0]->pendapatan_jasa_lain+$data[0]->pendapatan_jasa_dokter);   
     $total_keluar = ($data[0]->pembelian_barang+$data[0]->pengembalian_barang+$data[0]->barang_hilang+$data[0]->obat_hilang);
    @endphp
    <h6 class="mt-0 mb-3 bg-light p-2">Rincian Pemasukan</h6>
    <table style="width: 100%">
        <tr>
            <td><b>Penjualan Barang</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->penjualan_barang,2)}}</td>
        </tr>
        <tr>
            <td><b>Penjualan Obat</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->penjualan_obat,2)}}</td>
        </tr>
        <tr>
            <td><b>Piutang Obat</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->piutang_obat,2)}}</td>
        </tr>
        <tr>
            <td><b>Pendapatan Jasa Lain</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->pendapatan_jasa_lain,2)}}</td>
        </tr>
        <tr>
            <td><b>Pendapatan Jasa Dokter</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->pendapatan_jasa_dokter,2)}}</td>
        </tr>

    </table>
    <hr>
    <h6 class="mt-0 mb-3 bg-light p-2">Rincian Pengeluaran</h6>
    <table style="width: 100%">
        <tr>
            <td><b>Pembelian Barang</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->pembelian_barang,2)}}</td>
        </tr>
        <tr>
            <td><b>Pembelian Obat</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->pembelian_obat,2)}}</td>
        </tr>
        <tr>
            <td><b>Barang Hilang</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->barang_hilang,2)}}</td>
        </tr>
        <tr>
            <td><b>Obat Hilang</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->obat_hilang,2)}}</td>
        </tr>
        <tr>
            <td><b>Pengembalian Barang</b></td>
            <td>:</td>
            <td class="text-right">Rp {{number_format($data[0]->pengembalian_barang,2)}}</td>
        </tr>
    </table>
    <hr>
    <h6 class="mt-0 mb-3 bg-light p-2">Total</h6>
    <table class="float-right">
        <tr>
            <td><b>Total Pemasukan</b></td>
            <td>:</td>
            <td>Rp {{number_format($total_masuk,2)}}</td>
        </tr>
        <tr>
            <td><b>Total Pengeluaran</b></td>
            <td>:</td>
            <td>Rp {{number_format($total_keluar,2)}}</td>
        </tr>
        <tr>
            <td><b>Laba (Rugi) Kotor</b></td>
            <td>:</td>
            <td>Rp {{number_format($total_masuk-$total_keluar,2)}}</td>
        </tr>
    </table>

</body>
</html>