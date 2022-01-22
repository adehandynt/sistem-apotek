
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
         
            @endphp
			<tr style="background-color:#ffffff">
                @if($p->no_transaksi!=$no_transaksi_temp)
				<td>{{$i}}</td>
				<td>{{$p->no_transaksi}}</td>
				<td>{{$p->tgl_transaksi}}</td>
                <td>{{$p->nama_barang}}</td>
				{{-- <td> Rp {{number_format($p->total / $p->jumlah,2)}}</td> --}}
                <td>{{$p->jumlah }}</td>
				<td>{{$p->total}}</td>
				<td>{{$p->nama_staf}}</td>
                @php
                $i++;  
                @endphp
                @else
				<td></td>
				<td></td>
				<td></td>
                <td>{{$p->nama_barang}}</td>
				{{-- <td> Rp {{number_format($p->total / $p->jumlah,2)}}</td> --}}
                <td>{{$p->jumlah }}</td>
				<td></td>
				<td></td>
                @endif
			</tr>
            @php
              $no_transaksi_temp=$p->no_transaksi;   
            @endphp
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
