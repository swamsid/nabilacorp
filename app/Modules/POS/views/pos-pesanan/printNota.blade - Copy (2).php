<!DOCTYPE html>
<html>
<head>
  <title>Print Nota</title>
</head>
<style type="text/css">
  
  *{
    font-family: consolas;
  }
  .div-width{
    width: 80mm;
    margin-left: -10px;
    margin-top: -10px;
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
<body>
  <div class="div-width">
    <div>    
      <div class="float-left">
        <img src="{{ asset('/assets/logo.jpg') }}"  width="50px" height="50px">
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
    <!--<div class="divided"></div>-->
    *****************************************
    
    <table class="border-none" width="100%">    

@foreach($data['sales_dt'] as $detail)
          <tr>
          <td width="38%">{{$detail->i_name}}</td>
          <td width="45%" >
          <div style="text-align: right">
          {{$detail->sd_qty}} {{$detail->s_name}} * {{number_format($detail->sd_price,'0',',','.')}}
          @if($detail->sd_disc_value!='0.00' || $detail->sd_disc_percentvalue!='0.00')
          </div>
          <div style="text-align: right">
          -{{number_format($detail->sd_disc_value+$detail->sd_disc_percentvalue,'0',',','.')}}</div>
          @endif
          </td>
          <td width="17%" style="text-align: right">{{number_format($detail->sd_total,'0',',','.')}}</td>
          </tr>
 @endforeach


           <td colspan="3">
    *****************************************
          
        </td>
      </tr>
      <tr>
        <td width="40%"></td>
        <td class="text-right bold" width="25%">Total Diskon</td>
        <td width="30%"><div style="text-align: right">{{number_format($data['sales']->s_disc_percent+$data['sales']->s_disc_value,0,',','.')}}</div></td>        
      </tr>
      <tr>
        <td width="40%"></td>
        <td class="text-right bold" width="25%">Total</td>
        <td width="30%"><div style="text-align: right">{{number_format($data['sales']->s_net,0,',','.')}}</div></td>        
      </tr>
      <tr>
        <td width="40%"></td>
        <td class="text-right bold" width="25%">Total Bayar</td>
        <td width="30%"><div style="text-align: right">{{number_format($data['sales']->s_bayar,0,',','.')}}</div></td>
      </tr> 
      <tr>
        <td width="40%"></td>
        <td class="text-right bold" width="25%">Sisa Bayar</td>
        <td width="30%"><div style="text-align: right">{{number_format($data['sales']->s_net-$data['sales']->s_bayar,0,',','.')}}</div></td>
      </tr>           
    </table>
    <br>
    <div class="one-hundred">
      <small">
        <center>
          Terima kasih Semoga berkah, rejekinya lancar
        </center>
      </small>
    </div>
  </div>
</body>

<script>

  // (C) 2000 www.CodeLifter.com
  // http://www.codelifter.com
  // Free for all users, but leave in this  header
  printWindow();
  function printWindow(){
     bV = parseInt(navigator.appVersion)
     if (bV >= 4) window.print()
  }
  </script>

</html>