   @foreach($data as $detail)
     <tr>   
          <tr class="detailBahan{{$detail->i_id}}">

               <td>
               <input style="width:100%" type="hidden" name="mm_mutationitem[]" value="{{$detail->mm_mutationitem}}">
               <input style="width:100%" type="hidden" name="mm_detailid[]" value="{{$detail->mm_detailid}}">
               <input style="width:100%" type="hidden" name="mm_item[]" value="{{$detail->i_id}}">

          <input value="{{$detail->mm_comp}}" style="width:100%" type="hidden" name="mm_comp[]">
          <input value="{{$detail->mm_position}}" style="width:100%" type="hidden" name="mm_position[]">
                    <div style="padding-top:6px">{{$detail->i_code}} - {{$detail->i_name}}</div></td>
@if($dt!='dt')
          <td><input class="stock stock{{$detail->i_id}} form-control" style="width:100%;text-align:right;border:none" value="{{number_format($detail->s_qty+$detail->mm_qty,0,',','.')}}" readonly=""></td>
@endif
          <td style="display:none"><input class="jumlahAwal{{$detail->i_id}}" style="width:100%;text-align:right;border:none" name="jumlahAwalBahan[]" value="{{number_format($detail->mm_qty,'0',',','.')}}"></td>
          <td><input 
                    @if($dt=='dt')
                         disabled="" 
                    @endif
           onblur="validationFormBahan();" onkeyup="cekStockMutasi('{{$detail->i_id}}');hapusBahanB(event,'{{$detail->i_id}}');validationFormBahan();" class="jumlah fQty{{$detail->i_id}}" style="width:100%;text-align:right;border:none" name="mm_qty[]" value="{{number_format($detail->mm_qty,0,',','.')}}"></td>

          <td><div style="padding-top:6px">{{$detail->s_name}}</div></td>
@if($dt!='dt')
          <td>
               <button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusButtonBahan('{{$detail->i_id}}')"><i class="fa fa-trash-o"></i></button>
          </td>
@endif
          </tr>
          @endforeach

<script type="text/javascript">

     
     tampBahan=<?php echo json_encode($tamp); ?>;
     hapusSalesDt=[];
     console.log(tampBahan);
</script>



