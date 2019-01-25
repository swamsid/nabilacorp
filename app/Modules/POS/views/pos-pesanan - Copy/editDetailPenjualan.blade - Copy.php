   @foreach($data as $detail)
     <tr>   
          <tr class="detail{{$detail->i_id}}">

               <td>
               <input style="width:100%" type="hidden" name="sd_sales[]" value="{{$detail->sd_sales}}">
               <input style="width:100%" type="hidden" name="sd_detailid[]" value="{{$detail->sd_detailid}}">
               <input style="width:100%" type="hidden" name="sd_item[]" value="{{$detail->i_id}}">
                    <div style="padding-top:6px">{{$detail->i_code}} - {{$detail->i_name}}</div></td>

          <td><input class="stock stock{{$detail->i_id}}" style="width:100%;text-align:right;border:none" value="{{$detail->s_qty+$detail->sd_qty}}" readonly=""></td>
          <td style="display:none"><input class="jumlahAwal{{$detail->i_id}}" style="width:100%;text-align:right;border:none" name="jumlahAwal[]" value="{{$detail->sd_qty}}"></td>
          <td><input onblur="validationForm();" onkeyup="validationForm();hitungTotalPerItemPesanan('{{$detail->i_id}}')" class="jumlah fQty{{$detail->i_id}}" style="width:100%;text-align:right;border:none" name="sd_qty[]" value="{{$detail->sd_qty}}"></td>

          <td><div style="padding-top:6px">{{$detail->s_name}}</div></td>
          <td><input class="harga{{$detail->i_id}} alignAngka" style="width:100%;border:none" name="sd_price[]" value="{{number_format($detail->sd_price,0,',','.')}}"" readonly></td>

          <td><input class="alignAngka discRp{{$detail->i_id}}" style="width:100%;border:none" name="sd_disc_value[]" id="discRp" onkeyup="hitungTotalPerItemPesanan('{{$detail->i_id}}');rege(event,'discRp{{$detail->i_id}}')" onblur="setRupiah(event,'{{$detail->i_id}}')" onclick="setAwal(event,'{{$detail->i_id}}')" value="{{number_format($detail->sd_disc_value,0,',','.')}}" ></td>

          <td><input class="alignAngka discP{{$detail->i_id}}" onkeyup="hitungTotalPerItemPesanan('{{$detail->i_id}}')" style="width:100%;border:none" name="sd_disc_percent[]" id="discP" value="{{$detail->sd_disc_percent}}"></td>

          <td style="display:none"><input class="alignAngka discPV{{$detail->i_id}}" onkeyup="hitungTotalPerItemPesanan('{{$detail->i_id}}')" style="width:100%;border:none" name="sd_disc_percentvalue[]" id="discPV" value="{{number_format($detail->sd_disc_percentvalue,0,',','.')}}"></td>          

          <td style="display:none"><input style="width:100%;border:none" name="sd_total[]" class="totalPerItem alignAngka totalPerItem{{$detail->i_id}}" readonly value="{{$detail->sd_qty*$detail->sd_price}}"></td>

          <td><input style="width:100%;border:none" name="sd_total_disc[]" class="totalPerItemDisc alignAngka totalPerItemDisc{{$detail->i_id}}" readonly value="{{number_format($detail->sd_total,0,',','.')}}"></td>
          <td>
               <button type="button" class="btn btn-sm btn-danger hapus" onclick="hapus('{{$detail->i_id}}')"><i class="fa fa-trash-o"></i></button>
          </td>
          </tr>
          @endforeach

<script type="text/javascript">

     
     tamp=<?php echo json_encode($tamp); ?>;
     console.log(tamp);
</script>



