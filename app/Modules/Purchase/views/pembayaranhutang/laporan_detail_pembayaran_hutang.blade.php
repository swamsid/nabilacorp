<style>
  td, th {
    border:1px solid #000;
  }
  td::after {
    content : " ";
  }
</style>

<table id="tabel_d_payable" class="table tabelan table-hover table-bordered table-striped" width="100%" cellspacing="0">
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
    	@foreach($d_payable_detail as $index => $item)
          @if( count( $item['payments'] ) <= 1 )
              <tr>
                  <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{$index+1}}</td> 
                  <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['p_code'] }}</td>
                  @if( count( $item['payments'] ) == 0 )
                      <td colspan="2">Belum ada transaksi</td>
                  @else
                      <td>{{ $item['payment'][0]['pd_datepay'] }}</td>
                      <td>{{ $item['payment'][0]['pd_value'] }}</td>
                  @endif
                  <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['p_outstanding'] == null ? 0 : $item['p_outstanding'] }}</td>
                  <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['p_pay'] == null ? 0 : $item['p_pay'] }}</td>
              </tr>
          @else
            @foreach( $item['payments'] as $x => $payment )
              @if($x == 0)
                  <tr>
                      <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{$index+1}}</td> 
                      <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['p_code'] }}</td>
                      @if( count( $item['payments'] ) == 0 )
                          <td colspan="2">Belum ada transaksi</td>
                      @else
                          <td>{{ $payment['pd_datepay'] }}</td>
                          <td>{{ $payment['pd_value'] }}</td>
                      @endif
                      <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['p_outstanding'] == null ? 0 : $item['p_outstanding'] }}</td>
                      <td rowspan="{{ count( $item['payments'] ) == 0 ? 1 : count( $item['payments'] ) }}">{{ $item['p_pay'] == null ? 0 : $item['p_pay'] }}</td>
                  </tr>

              @else
                  <tr>  
                      <td></td>
                      <td></td>
                      <td>{{ $payment['pd_datepay'] }}</td>
                      <td>{{ $payment['pd_value'] }}</td>
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
		