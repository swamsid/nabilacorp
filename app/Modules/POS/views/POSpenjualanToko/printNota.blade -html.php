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
    <!--<div class="divided"></div>-->    
    
    
    <table class="border-none" width="155px">    
           <td colspan="3">    
    *****************************************
          
        </td>

@foreach($data['sales_dt'] as $detail)
          <tr>
          <td width="38%">{{$detail->i_name}}</td>
          <td width="45%" >

          <div>
          {{$detail->sd_qty}} {{$detail->s_name}} * {{number_format($detail->sd_price,'0',',','.')}}

          @if($detail->sd_disc_value!='0.00' || $detail->sd_disc_percentvalue!='0.00')
          </div>

          <div>
          -{{number_format($detail->sd_disc_value+$detail->sd_disc_percentvalue,'0',',','.')}}
          </div>
          @endif
          </td>

          <td>
                    <div>
                        {{number_format($detail->sd_qty*$detail->sd_price,'0',',','.')}}                  
                    </div>
                    @if($detail->sd_disc_value!='0.00' || $detail->sd_disc_percentvalue!='0.00')
                      <div>
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
        <td width="50px" style="font-size: 5px">Item: {{$jumlah}}</td>
        <td class="text-right bold" width="25%">Total</td>
        <td width="30%"><div style="text-align: right">{{number_format($data['sales']->s_net,0,',','.')}}</div></td>        
      </tr>
      <tr>
        <td style="font-size: 5px">Master</td>
        <td class="text-right bold" width="25%">Diskon</td>
        <td width="30%"><div style="text-align: right">{{number_format($data['sales']->s_disc_percent+$data['sales']->s_disc_value,0,',','.')}}</div></td>        
      </tr>
      <tr>
        <td width=""></td>
        <td class="text-right bold" width="25%">Bayar</td>
        <td width="30%"><div style="text-align: right">{{$bayar}}</div></td>        
      </tr>
      <tr>
        <td width=""></td>
        <td class="text-right bold" width="25%">Kembali</td>
        <td width="30%"><div style="text-align: right">{{$kembalian}}</div></td>        
      </tr>
      
    </table>
    <br>
    <div style="font-size: 5px">
      
          Terima kasih Semoga berkah, rejekinya lancar
        
    </div>
</body>
</html>