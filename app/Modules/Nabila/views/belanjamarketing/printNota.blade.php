
<style type="text/css">
  
  *{
/*    font-family: consolas;*/
  }
  .div-width{
    width: 80mm;
    margin-left: 10px;
    margin-top: 10px;
    /*margin: auto;*/
  }
  .float-left{
    float: left;
  }
  .float-right{
    float: right;
  }
  
  @media print{
    .btn-print{
      margin: 0;
      padding: 0;
      display: hidden;
    }
  }
  @page{
    
    size: portrait;
    margin: 0;
  }
  .border-none table td th{
    border:hidden;
  }
  .one-hundred{
    width: 100%;
  }
  .text-left{
    text-align: left;
  }
  .text-right{
    text-align: right;
  }
  .bold{
    font-weight: bold;
  }
  *{
    font-size: 15px;
  }
</style>
  <div class="div-width">








<div>    
          <div class="float-left">
            <img src="{{ asset('/assets/logo.png') }}"  width="50px" height="50px">
          </div>
          <div class="float-left" style="margin-left: 5px;">
            
              Nabila Cake Bakery & Pastry<br>
              Jl. Gajah Mada No.22 Ponorogo<br>
              uuenaknya pake buuanget
            
          </div>
      </div>
    <br>
    <br>
    <br>
    <br>
    <div>
    Nota :{{$data['sales']->s_note}}
    </div>
    <!--<div class="divided"></div>-->
    ***************************************** 
    
    
    <table class="border-none" width="100%">    
@foreach($data['sales_dt'] as $detail)
          <tr>
          <td width="38%">{{$detail->i_name}}</td>
          <td width="48%">

          <div style="text-align: right; ">
          {{$detail->sd_qty}} {{$detail->s_name}} * {{number_format($detail->sd_price,'0',',','.')}}

          @if($detail->sd_disc_value!='0.00' || $detail->sd_disc_percentvalue!='0.00')
          </div>

          <div style="text-align: right;">
          -{{number_format($detail->sd_disc_value+$detail->sd_disc_percentvalue,'0',',','.')}}
          </div>
          @endif
          </td>

          <td width="" style="text-align: right;">
                    <div style="text-align: right; ">
                        {{number_format($detail->sd_qty*$detail->sd_price,'0',',','.')}}                  
                    </div>
                    @if($detail->sd_disc_value!='0.00' || $detail->sd_disc_percentvalue!='0.00')
                      <div style="text-align: right;">
                        {{number_format($detail->sd_total,'0',',','.')}}                  
                      </div>
                    @endif
          </td>
          </tr>
 @endforeach


           <td colspan="3">    
    *****************************************
          
        </td>
      </tr>
      <tr>
        <td width="50px" style="">Item: {{$jumlah}}</td>
        <td class="text-right bold" width="" style="">Total</td>
        <td width="20px"><div style="text-align: right;">{{number_format($data['sales']->s_net,0,',','.')}}</div></td>        
      </tr>
      <tr>
        <td style=""></td>
        <td class="text-right bold" width="" style="">Diskon</td>
        <td width=""><div style="text-align: right;">{{number_format($data['sales']->s_disc_percent+$data['sales']->s_disc_value,0,',','.')}}</div></td>        
      </tr>
      <tr>
         <td colspan="3">    
    *****************************************
          
        </td>
      </tr>
      <tr>          
                <td style="45%">Tanggal</td>
                <td class="text-right bold" width="25%" style=""></td>
                <td width="35%"><div style="text-align: right;">Nominal</div></td>
      </tr>

      <tr>
          @foreach($piutang as $dtp)
                <td style="">{{$dtp->rd_datepay}}</td>
                <td class="text-right bold" style=""></td>
                <td width=""><div style="text-align: right;">{{$dtp->rd_value}}</div></td>                
          @endforeach
      </tr>

       <tr>
         <td colspan="3">    
    *****************************************
          
        </td>
        </tr>
      <tr>
        <td width="45"></td>
        <td class="text-right bold" width="25%" style="">Bayar</td>
        <td width="30%"><div style="text-align: right;">{{number_format($data['sales']->s_bayar,0,',','.')}}</div></td>        
      </tr>

      <tr>
        <td width="45"></td>
        <td class="text-right bold" width="25%">Sisa Hutang</td>
        <td width="30%"><div style="text-align: right;">{{number_format($piutang[0]->r_outstanding,0,',','.')}}</div></td>        
      </tr>
      
    </table>
    <br>
    <div style="">
      
          Final kasih Semoga berkah, rejekinya lancar
        
    </div>

