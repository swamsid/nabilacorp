   @foreach($data as $detail)
<tr class="detail{{$detail->i_id}}">
          <td width="23%"><input style="width:100%" type="hidden" name="prdt_item[]" value='{{$detail->prdt_item}}'>
          <input style="width:100%" type="hidden" name="prdt_productresult[]" value="{{$detail->prdt_productresult}}">
          <input style="width:100%" type="hidden" name="prdt_detailid[]" value="{{$detail->prdt_detailid}}">
          <input value="{{$detail->prdt_comp}}" style="width:100%" type="hidden" name="comp[]">
          <input value="{{$detail->prdt_position}}" style="width:100%" type="hidden" name="position[]">
          <div style="padding-top:6px">{{$detail->i_code}} - {{$detail->i_name}}</div></td>

          <td><input class="stock stock{{$detail->i_id}} form-control" style="width:100%;text-align:right;border:none" value="{{number_format($detail->s_qty,0,',','.')}}" readonly=""></td>

            <td style="display:none"><input class="jumlahAwal{{$detail->i_id}}" style="width:100%;text-align:right;border:none" name="jumlahAwal[]" value="{{number_format($detail->prdt_qty,'0',',','.')}}"></td>

          <td><input onblur="validationForm();setQty(event,'fQty{{$detail->i_id}}')" onclick="setAwal(event,'fQty{{$detail->i_id}}')" onkeyup="hapus(event,'{{$detail->i_id}}');validationForm()" class="jumlah fQty{{$detail->i_id}}" style="width:100%;text-align:right;border:none" name="prdt_qty[]" value="{{number_format($detail->prdt_qty,0,',','.')}}"></td>

          <td><div style="padding-top:6px">{{$detail->s_name}}</div></td>
          
        <td><input class="harga{{$detail->i_id}} alignAngka" style="width:100%;border:none" name="prdt_hpp[]" value="{{number_format($detail->prdt_hpp,0,',','.')}}" ></td>
                 

          <td width="3%" align="center">
               <button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusButton('{{$detail->prdt_item}}')"><i class="fa fa-trash-o"></i></button>
          </td>                            
</tr>
          @endforeach

<script type="text/javascript">

     tamp=[];
     tamp=<?php echo json_encode($tamp); ?>;
     hapusDt=[];
     console.log(tamp);
</script>



