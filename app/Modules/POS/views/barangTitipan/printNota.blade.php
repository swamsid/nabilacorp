 
    <table class="border-none" width="155px">
      <td>
        <img src="{{ asset('/assets/logo.jpg') }}"  width="5px" height="5px">
      </td>
        <td style="margin-left: 5px; font-size: 6.8px;font-family: consolas ">
          Nabila Cake Bakery & Pastry<br>
          Jl. Gajah Mada No.22 Ponorogo<br>
          uuenaknya pake buuanget
      </td>
    </table>
    <!--<div class="divided"></div>-->    
    
    
    <table class="border-none" width="155px">    
           <td colspan="3">    
    -------------------------------------------------
          
        </td>

@foreach($data['sales_dt'] as $detail)
          <tr>
          <td width="4px" style="font-size: 5px">{{$detail->i_name}}</td>
          <td width="5px" >
          <div style="text-align: right; font-size: 5px">
          {{$detail->sd_qty}} {{$detail->s_name}} * {{number_format($detail->sd_price,'0',',','.')}}
          @if($detail->sd_disc_value!='0.00' || $detail->sd_disc_percentvalue!='0.00')
          </div>
          <div style="text-align: right;font-size: 5px">
          -{{number_format($detail->sd_disc_value+$detail->sd_disc_percentvalue,'0',',','.')}}</div>
          @endif
          </td>
          <td width="5px" style="text-align: right;font-size: 5px">{{number_format($detail->sd_total,'0',',','.')}}</td>
          </tr>
 @endforeach


           <td colspan="3">    
    -------------------------------------------------
          
        </td>
      </tr>
      <tr>
        <td width=""></td>
        <td class="text-right bold" width="4px" style="font-size: 5px">Total Diskon</td>
        <td width=""><div style="text-align: right;font-size: 5px">{{number_format($data['sales']->s_disc_percent+$data['sales']->s_disc_value,0,',','.')}}</div></td>        
      </tr>
      <tr>
        <td width="50px"></td>
        <td class="text-right bold" width="30px" style="font-size: 5px">Total</td>
        <td width="20px"><div style="text-align: right;font-size: 5px">{{number_format($data['sales']->s_net,0,',','.')}}</div></td>        
      </tr>
    </table>
    <br>
    <div style="font-size: 5px">
      
          Terima kasih Semoga berkah, rejekinya lancar
        
    </div>
