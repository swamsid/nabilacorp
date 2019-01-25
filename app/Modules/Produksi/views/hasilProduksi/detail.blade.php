   @php
      $no=1; 
    @endPhp
   @foreach($data as $detail)
<tr class="detail{{$detail->i_id}}">
          <td><div class="alignAngka" style="padding-top:6px">{{$no}}</div></td>
          <td><input style="width:100%" type="hidden" name="prdt_item[]" value='{{$detail->prdt_item}}'>
          <div style="padding-top:6px">{{$detail->i_code}} - {{$detail->i_name}}</div></td>
          <td><div class="alignAngka" style="padding-top:6px">{{number_format($detail->prdt_qty,0,',','.')}}</div></td>

          <td><div style="padding-top:6px">{{$detail->s_name}}</div></td>
          
        <td><div class="alignAngka" style="padding-top:6px">{{number_format($detail->prdt_hpp,0,',','.')}}</div></td>
</tr>
   @php
      $no++; 
    @endPhp
          @endforeach





