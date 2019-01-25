<style type="text/css">      
   body {
    font-size: 75.5%;
    font-style: calibri;
     padding:0; margin:0;
     }
    @page {
        width: 80mm; 
        margin: 0;
    }
    @media print {
        html, body {
            width: 80mm;            
        }      
    }
   th, td{
     font-size: 75.5%;
     font-style: calibri;
      padding:0; margin:0;
    }
</style>

<table width="100%">
<tr>
     <th width="15%"><img src="{{ asset('/assets/logo.png') }}" alt="no logo" width="60%" height="35%"></th>
     <th width="80%"><span style="font-size: 130%">Nabila Cake Bakery & Pastry</span>
     <br>
     <center> Jl. Gajah Mada No.22 Ponorogo</center>
     </th>
     <th width="5%"></th>
</tr>
uuenaknya pake banget
<tr>
     <th colspan="3">
     -------------------------------------------------------------------------
     </th>
</tr>
<tr>
     <th colspan="3">
          No : {{$data['sales']->s_note}}
     </td>
</tr>
<tr>
     <th colspan="3">
          Nama : @if($data['sales']->c_name!='') {{$data['sales']->c_name}} @else - @endif
     </td>
</tr>
</table>
---------------------------------------------------------------------------
<table width="100%">
     @foreach($data['sales_dt'] as $detail)
          <tr>
          <td width="40%">{{$detail->i_name}}</td>
          <td width="35%">{{$detail->sd_qty}} {{$detail->s_name}} * {{number_format($detail->sd_price,'0',',','.')}}</td>
          <td width="5%"></td>
          <td width="25%">{{number_format($detail->sd_total,'0',',','.')}}</td>
          </tr>
     @endforeach
     <tr>
          <td colspan="4">---------------------------------------------------------------------------</td>          
     </tr>
     <tr>
          <td colspan="1" ></td>
          <td colspan="1" >Gross</td>
          <td colspan="1" ></td>
          <td colspan="1" >{{number_format($data['sales']->s_gross,0,',','.')}}</td>
     </tr>
     <tr>
          <td colspan="1" ></td>
          <td colspan="1">Disc:</td>
          <td colspan="1" ></td>
          <td colspan="1" >{{number_format($data['sales']->s_disc_percent+$data['sales']->s_disc_value,0,',','.')}}</td>
     </tr>
     <tr>
          <td colspan="1" ></td>
          <td colspan="1" style="text-align: ">Onkir:</td>
          <td colspan="1" ></td>
          <td colspan="1" >{{number_format($data['sales']->s_disc_percent+$data['sales']->s_disc_value,0,',','.')}}</td>
     </tr>
      <tr>
          <td colspan="1" ></td>
          <td colspan="1" style="text-align: ">Net:</td>
          <td colspan="1" ></td>
          <td colspan="1" >{{number_format($data['sales']->s_net,0,',','.')}}</td>
     </tr>
     <tr>
          <td colspan="1" ></td>
          <td colspan="1" style="text-align: ">Dibayar:</td>
          <td colspan="1" ></td>
          <td colspan="1" >{{number_format($data['sales']->s_net,0,',','.')}}</td>
     </tr>
     <tr>
          <td colspan="1" ></td>
          <td colspan="1" style="text-align: ">Kembali:</td>
          <td colspan="1" ></td>
          <td colspan="1" >{{number_format($data['sales']->s_net,0,',','.')}}</td>
     </tr>


</table>


</body>
<script type="text/javascript">
      window.onload = function () {
    window.print();
}
</script>