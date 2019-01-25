<style type="text/css">      
   body {
    font-size: 70.5%;
    font-style: calibri;
     padding:0; margin:0;
     }
    @page {
        width: 58mm; 
        margin: 0;
    }
    @media print {
        html, body {
            width: 58mm;            
        }      
    }
    td{
     font-size: 70.5%;
     font-style: calibri;
      padding:0; margin:0;
    }
</style>
<body>
<div>
     <center>
     Jl. Gajah Mada No.22, Ponorogo
     085 335 015 099
     </center>
</div>
<!-- uuenaknya pake banget -->
------------------------------------------------------
<div>No : {{$data['sales']->s_note}}</div>
<div>Nama : @if($data['sales']->c_name!='') {{$data['sales']->c_name}} @else - @endif</div>
------------------------------------------------------
<table width="100%">
     @foreach($data['sales_dt'] as $detail)
          <tr>
          <td width="40%">{{$detail->i_name}}</td>
          <td width="25%">{{$detail->sd_qty}} {{$detail->s_name}} * {{number_format($detail->sd_price,'0',',','.')}}</td>
          <td width="35%">{{number_format($detail->sd_total,'0',',','.')}}</td>
          </tr>
     @endforeach
     <tr>
          <td colspan="3">------------------------------------------------------</td>          
     </tr>
     <tr>
          <td colspan="1" >Gross</td>
          <td colspan="2" style="padding-left: 23%">{{number_format($data['sales']->s_gross,0,',','.')}}</td>
     </tr>
     <tr>
          <td colspan="1" style="text-align: ">Disc:</td>
          <td colspan="2" style="padding-left: 23%">{{number_format($data['sales']->s_disc_percent+$data['sales']->s_disc_value,0,',','.')}}</td>
     </tr>
     <tr>
          <td colspan="1" style="text-align: ">Onkir:</td>
          <td colspan="2" style="padding-left: 23%">{{number_format($data['sales']->s_disc_percent+$data['sales']->s_disc_value,0,',','.')}}</td>
     </tr>
      <tr>
          <td colspan="1" style="text-align: ">Net:</td>
          <td colspan="2" style="padding-left: 23%">{{number_format($data['sales']->s_net,0,',','.')}}</td>
     </tr>
     <tr>
          <td colspan="1" style="text-align: ">Dibayar:</td>
          <td colspan="2" style="padding-left: 23%">{{number_format($data['sales']->s_net,0,',','.')}}</td>
     </tr>
     <tr>
          <td colspan="1" style="text-align: ">Kembali:</td>
          <td colspan="2" style="padding-left: 23%">{{number_format($data['sales']->s_net,0,',','.')}}</td>
     </tr>


</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</body>
<script type="text/javascript">
     window.print();
</script>