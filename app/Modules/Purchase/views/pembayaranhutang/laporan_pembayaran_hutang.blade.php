<style>
  td, th {
    border:1px solid #000;
  }
</style>

<table id="tabel_d_payable" class="table tabelan table-hover table-bordered table-striped" width="100%" cellspacing="0">
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
    	@foreach($d_payable_data as $index => $item)
    	 <tr>
          <td>{{$index+1}}</td> 
          <td>{{ $item->p_date }}</td>
          <td>{{ $item->p_duedate }}</td>
          <td>{{ $item->p_code }}</td>
          <td>{{ $item->p_ref }}</td>
          <td>{{ $item->p_value }}</td>
          <td>{{ $item->pd_value == null ? 0 : $item->pd_value }}</td>
          <td>{{ $item->p_outstanding }}</td>
 
       </tr>
    	@endforeach
    </tbody>
</table>


    <div class="float-left" style="width: 30vw;">
      <table >
        <tr>
          <td>Total Hutang</td>
          <td>:</td>                    
          <td align="right">{{number_format($d_payable_total_hutang,2,',','.')}}</td>
        </tr>
        <tr>        
          <td>Total Hutang Terbayar</td>
          <td>:</td>
          <td align="right">{{number_format($d_payable_total_hutang_belum_terbayar,2,',','.')}}</td>
        </tr>
        <tr>
          <td>Total Hutang Belum Terbayar</td>
          <td>:</td>
          <td align="right">{{number_format($d_payable_total_hutang_terbayar,2,',','.')}}</td>
        </tr>
      </table>
    </div>
		