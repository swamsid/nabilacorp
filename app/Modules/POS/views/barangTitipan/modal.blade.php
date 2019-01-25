

   @php
        $totalTerjual=0;
   @endPhp
   @foreach($data as $detail)
   @php
        $totalTerjual+=$detail->terjual*$detail->idt_price;
   @endPhp
     
          <tr class="detail{{$detail->i_id}}">

          <td>
                    <div >{{$detail->i_code}} - {{$detail->i_name}}</div>
          </td>


          <td class="alignAngka">{{number_format($detail->idt_qty,0,',','.')}} </td>


            <td class="alignAngka" style="display: none;">{{number_format($detail->s_qty,0,',','.')}} </td>

          <td class="alignAngka">{{number_format($detail->idt_terjual,0,',','.')}}</td>


          <td class="alignAngka">{{number_format($detail->idt_return_titip,0,',','.')}}
          </td>

          
          <td><div >{{$detail->s_name}}</div></td>
          <td class="alignAngka"> {{number_format($detail->idt_price,0,',','.')}} </td>



          <td class="alignAngka">{{number_format($detail->idt_qty*$detail->idt_price,0,',','.')}}</td>
          <td>
            {{$detail->idt_action}}
          </td>
          </tr>
          @endforeach

