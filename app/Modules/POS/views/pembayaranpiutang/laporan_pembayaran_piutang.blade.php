<style>
  td, th {
    border:1px solid #000;
  }
</style>

<table id="tabel_d_receivable" class="table tabelan table-hover table-bordered table-striped" width="100%" cellspacing="0">
    <thead>
       <tr>
          <th align="center"  width="1%">No</th>
          <th>Tanggal</th>
          <th>Tanggal Jatuh Tempo</th>
          <th>Kode</th>
          <th>Ref</th>
          <th>Jumlah Hutang</th>
          <th>Jumlah Terbayar</th>
          <th>Sisa</th>                                       
       </tr>
    </thead>
    <tbody>
    	@foreach($d_receivable_data as $index => $item)
    	 <tr>
          <td>{{$index+1}}</td> 
          <td>{{ $item->r_date }}</td>
          <td>{{ $item->r_duedate }}</td>
          <td>{{ $item->r_code }}</td>
          <td>{{ $item->r_ref }}</td>
          <td>{{ $item->r_value }}</td>
          <td>{{ $item->rd_value == null ? 0 : $item->rd_value }}</td>
          <td>{{ $item->r_outstanding }}</td>
 
       </tr>
    	@endforeach
    </tbody>
</table>


    <div class="float-left" style="width: 30vw;">
      <table >
        <tr>
          <td>Total Hutang</td>
          <td>:</td>                    
          <td align="right">{{number_format($d_receivable_total_piutang,2,',','.')}}</td>
        </tr>
        <tr>        
          <td>Total Hutang Terbayar</td>
          <td>:</td>
          <td align="right">{{number_format($d_receivable_total_piutang_belum_terbayar,2,',','.')}}</td>
        </tr>
        <tr>
          <td>Total Hutang Belum Terbayar</td>
          <td>:</td>
          <td align="right">{{number_format($d_receivable_total_piutang_terbayar,2,',','.')}}</td>
        </tr>
      </table>
    </div>
		