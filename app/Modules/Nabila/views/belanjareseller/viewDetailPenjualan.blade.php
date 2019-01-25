   @foreach($data as $detail)
     <tr>   
          <tr class="detail{{$detail->i_id}}">

               <td>
                    <div style="padding-top:6px">{{$detail->i_code}} - {{$detail->i_name}}</div>
               </td>                         
               <td>
                    <div style="padding-top:6px">{{$detail->sd_qty}}</div>
               </td>   

          <td><div style="padding-top:6px">{{$detail->s_name}}</div></td>
          <td>{{number_format($detail->sd_price,0,',','.')}}</td>

          <td>{{number_format($detail->sd_disc_value,0,',','.')}}</td>

          <td>{{$detail->sd_disc_percent}}</td>

          <td>{{number_format($detail->sd_total,0,',','.')}}</td>          
          </tr>
          @endforeach




