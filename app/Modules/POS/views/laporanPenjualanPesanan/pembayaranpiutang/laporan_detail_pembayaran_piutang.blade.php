<style>
  td, th {
    border:1px solid #000;
  }
  td::after {
    content : " ";
  }
</style>

<table id="tabel_d_receivable" class="table tabelan table-hover table-bordered table-striped" width="100%" cellspacing="0">
    <thead>
       <tr>
          <th align="center"  width="1%">No</th>
          <th>No Nota</th>
          <th>Tanggal Pembayaran</th>
          <th>Jumlah Pembayaran</th>
          <th>Total Hutang Terbayar</th>
          <th>Sisa Pembayaran</th>
       </tr>
    </thead>
    <tbody>
    	@foreach($d_receivable_detail as $index => $item)
          @if( count( $item['payments'] ) <= 1 )
              <tr>
                  <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{$index+1}}</td> 
                  <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['r_code'] }}</td>
                  @if( count( $item['payments'] ) == 0 )
                      <td colspan="2">Belum ada transaksi</td>
                  @else
                      <td>{{ $item['payment'][0]['rd_datepay'] }}</td>
                      <td>{{ $item['payment'][0]['rd_value'] }}</td>
                  @endif
                  <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['r_outstanding'] == null ? 0 : $item['r_outstanding'] }}</td>
                  <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['r_pay'] == null ? 0 : $item['r_pay'] }}</td>
              </tr>
          @else
            @foreach( $item['payments'] as $x => $payment )
              @if($x == 0)
                  <tr>
                      <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{$index+1}}</td> 
                      <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['r_code'] }}</td>
                      @if( count( $item['payments'] ) == 0 )
                          <td colspan="2">Belum ada transaksi</td>
                      @else
                          <td>{{ $payment['rd_datepay'] }}</td>
                          <td>{{ $payment['rd_value'] }}</td>
                      @endif
                      <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['r_outstanding'] == null ? 0 : $item['r_outstanding'] }}</td>
                      <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['r_pay'] == null ? 0 : $item['r_pay'] }}</td>
                  </tr>

              @else
                  <tr>  
                      <td></td>
                      <td></td>
                      <td>{{ $payment['rd_datepay'] }}</td>
                      <td>{{ $payment['rd_value'] }}</td>
                  </tr>
              @endif  
            @endforeach
          @endif
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
		