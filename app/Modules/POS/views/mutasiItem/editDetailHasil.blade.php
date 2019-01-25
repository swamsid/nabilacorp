   @foreach($data as $detail)
     <tr>   
          <tr class="detailHasil{{$detail->i_id}}">

               <td>
               <input style="width:100%" type="hidden" name="mp_mutationitem[]" value="{{$detail->mp_mutationitem}}">
               <input style="width:100%" type="hidden" name="mp_detailid[]" value="{{$detail->mp_detailid}}">
               <input style="width:100%" type="hidden" name="mp_item[]" value="{{$detail->i_id}}">
               <input value="{{$detail->mp_comp}}" style="width:100%" type="hidden" name="mp_comp[]">
               <input value="{{$detail->mp_position}}" style="width:100%" type="hidden" name="mp_position[]">
                    <div style="padding-top:6px">{{$detail->i_code}} - {{$detail->i_name}}</div></td>
@if($dt!='dt')
          <td><input class="stock stock{{$detail->i_id}} form-control" style="width:100%;text-align:right;border:none" value="{{number_format($detail->s_qty,0,',','.')}}" readonly=""></td>
@endif
          <td style="display:none"><input class="jumlahAwal{{$detail->i_id}}" style="width:100%;text-align:right;border:none" name="jumlahAwalHasil[]" value="{{number_format($detail->mp_qty,'0',',','.')}}"></td>
          <td><input
                    @if($dt=='dt')
                         disabled="" 
                    @endif
           onblur="validationFormHasil();" onkeyup="hapusHasilH(event,'{{$detail->i_id}}');validationFormHasil()" class="jumlah fQty{{$detail->i_id}}" style="width:100%;text-align:right;border:none" name="mp_qty[]" value="{{number_format($detail->mp_qty,0,',','.')}}"></td>

          <td><div style="padding-top:6px">{{$detail->s_name}}</div></td>
          <td><input
                    @if($dt=='dt')
                         disabled="" 
                    @endif
                     class="harga{{$detail->i_id}} alignAngka" style="width:100%;border:none" name="mp_hpp[]" value="{{number_format($detail->mp_hpp,0,',','.')}}" ></td>

   

     
@if($dt!='dt')
       <td>
               <button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusButtonHasil('{{$detail->i_id}}')"><i class="fa fa-trash-o"></i></button>
          </td>
@endif
          </tr>
          @endforeach

<script type="text/javascript">

     
     tampHasil=<?php echo json_encode($tamp); ?>;
     hapusSalesDt=[];
     console.log(tampHasil);
</script>



