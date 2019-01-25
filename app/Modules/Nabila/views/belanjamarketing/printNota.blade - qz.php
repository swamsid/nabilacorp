 
    <table class="border-none" width="200">
      <td>
        <img src="{{ asset('/assets/logo.png') }}"  width="40" height="40">
      </td>
        <td style="margin-left: 5px; font-size: 6.8px;font-family: consolas ">
          <center>Nabila Cake Bakery & Pastry <br>
          Jl. Gajah Mada No.22 Ponorogo<br>

          uuenaknya pake buuanget
          </center>
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
          -{{number_format($detail->sd_disc_value+$detail->sd_disc_percentvalue,'0',',','.')}}
          </div>
          @endif
          </td>

          <td width="5px" style="text-align: right;font-size: 5px">
                    <div style="text-align: right; font-size: 5px">
                        {{number_format($detail->sd_qty*$detail->sd_price,'0',',','.')}}                  
                    </div>
                    @if($detail->sd_disc_value!='0.00' || $detail->sd_disc_percentvalue!='0.00')
                      <div style="text-align: right;font-size: 5px">
                        {{number_format($detail->sd_total,'0',',','.')}}                  
                      </div>
                    @endif
          </td>
          </tr>
 @endforeach


           <td colspan="3">    
    -------------------------------------------------
          
        </td>
      </tr>
      <tr>
        <td width="50px" style="font-size: 5px">Item: {{$jumlah}}</td>
        <td class="text-right bold" width="30px" style="font-size: 5px">Total</td>
        <td width="20px"><div style="text-align: right;font-size: 5px">{{number_format($data['sales']->s_net,0,',','.')}}</div></td>        
      </tr>
      <tr>
        <td style="font-size: 5px">Master</td>
        <td class="text-right bold" width="4px" style="font-size: 5px">Diskon</td>
        <td width=""><div style="text-align: right;font-size: 5px">{{number_format($data['sales']->s_disc_percent+$data['sales']->s_disc_value,0,',','.')}}</div></td>        
      </tr>
      <tr>
         <td colspan="3">    
    -------------------------------------------------
          
        </td>
      </tr>
      <tr>          
                <td style="font-size: 5px">Tanggal</td>
                <td class="text-right bold" width="4px" style="font-size: 5px"></td>
                <td width=""><div style="text-align: right;font-size: 5px">Nominal</div></td>
      </tr>

      <tr>
          @for($i=0; $i<count($sp_nominal['nominal']); $i++)
                <td style="font-size: 5px">@if($sp_nominal['date'][$i]==0){{date('d-m-Y')}} @else {{$sp_nominal['date'][$i]}} @endif</td>
                <td class="text-right bold" width="4px" style="font-size: 5px"></td>
                <td width=""><div style="text-align: right;font-size: 5px">{{$sp_nominal['nominal'][$i]}}</div></td>                
          @endfor
      </tr>

       <tr>
         <td colspan="3">    
    -------------------------------------------------
          
        </td>
        </tr>
      <tr>
        <td width=""></td>
        <td class="text-right bold" width="4px" style="font-size: 5px">Bayar</td>
        <td width=""><div style="text-align: right;font-size: 5px">{{$bayar}}</div></td>        
      </tr>

      <tr>
        <td width=""></td>
        <td class="text-right bold" width="4px" style="font-size: 5px">Sisa Hutang</td>
        <td width=""><div style="text-align: right;font-size: 5px">{{number_format($data['sales']->s_net-$ttlBayar,0,',','.')}}</div></td>        
      </tr>

      <tr>
        <td width=""></td>
        <td class="text-right bold" width="4px" style="font-size: 5px">kembalian</td>
        <td width=""><div style="text-align: right;font-size: 5px">@if($kembalian>0){{$kembalian}}@else 0 @endif</div></td>        
      </tr>
      
    </table>
    <br>
    <div style="font-size: 5px">
      
          Final kasih Semoga berkah, rejekinya lancar
        
    </div>
