   @php
        $totalTerjual=0;
   @endPhp
   @foreach($data as $detail)
   @php
        $totalTerjual+=$detail->terjual*$detail->idt_price;
   @endPhp
     <tr class="detail{{$detail->i_id}}">     
          <td width="23%">
               <input style="width:100%" type="hidden" name="idt_item[]" value="{{$detail->i_id}}">
               <input value="{{$detail->idt_comp}}" style="width:100%" type="hidden" name="comp[]">
               <input value="{{$detail->idt_position}}" style="width:100%" type="hidden" name="position[]">
               <input style="width:100%" type="hidden" name="idt_itemtitipan[]" value="{{$detail->idt_itemtitipan}}">
               <input style="width:100%" type="hidden" name="idt_detailid[]" value="{{$detail->idt_detailid}}">
               <div style="padding-top:6px">{{$detail->i_code}} - {{$detail->i_name}}</div>
          </td>

          <td width="4%">
               <input class="form-control stock stock'+i_id.val()+'" style="width:100%;text-align:right;border:none" 
               value="{{number_format($detail->s_qty,0,',','.')}}" readonly>
          </td>

          <td width="4%" style="display:none"><!-- jumlah awal -->
               <input class="jumlahAwal{{$detail->i_id}} form-control" style="width:100%;text-align:right;border:none" name="jumlahLama[]" value="{{number_format($detail->idt_qty,0,',','.')}}" autocomplete="off" >
          </td>

          <td width="4%">               <!-- jumlah di update -->

               <input  onblur="validationForm();setQty(event,'fQty{{$detail->i_id}}');chekJml('{{$detail->i_id}}')" onkeyup="hapus(event,'{{$detail->i_id}}');hitung('{{$detail->i_id}}');" onclick="setAwal(event,'{{$detail->i_id}}')" class="move up1  alignAngka jumlah fQty{{$detail->i_id}} form-control" style="width:100%;border:none" name="idt_qty[]" value="{{number_format($detail->idt_qty,0,',','.')}}" autocomplete="off" >

               <!-- <input class="jumlahAwal{{$detail->i_id}} form-control" style="width:100%;text-align:right;border:none" name="jumlah[]" value="{{number_format($detail->idt_qty,0,',','.')}}" autocomplete="off" > -->
          </td>

          <td width="4%">
               <input type="hidden" class="return return{{$detail->i_id}} form-control" name="idt_return_titip_lama[]"           
               value="{{number_format($detail->idt_return_,0,',','.')}}" style="width:100%;text-align:right;border:none" readonly="">

               <input onblur=";setQty(event,'return{{$detail->i_id}}')" onclick="setAwal(event,'return{{$detail->i_id}}')" class="return return{{$detail->i_id}} form-control" name="idt_return_titip[]"           
               value="{{number_format($detail->idt_return_,0,',','.')}}" style="width:100%;text-align:right;border:none" readonly="">
          </td>

          <td width="5%">               
               <div style="padding-top:6px">{{$detail->s_name}}</div>
          </td>
          
          <td><input class="harga{{$detail->i_id}} alignAngka form-control" style="width:100%;border:none" name="idt_price[]" value="{{number_format($detail->idt_price,0,',','.')}}"" readonly></td>



          <td><input style="width:100%;" name="idt_total[]" class="totalPerItemDisc alignAngka totalPerItemDisc{{$detail->i_id}} form-control" readonly value="{{number_format($detail->idt_qty*$detail->idt_price,0,',','.')}}"></td>

          <td width="3%">
               <button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusButton('{{$detail->i_id}}')" disabled=""><i class="fa fa-trash-o"></i></button>
          </td>
     </tr>

          @endforeach

<script type="text/javascript">

     
     tamp=<?php echo json_encode($tamp); ?>;
     hapusSalesDt=[];
     console.log(tamp);
</script>



