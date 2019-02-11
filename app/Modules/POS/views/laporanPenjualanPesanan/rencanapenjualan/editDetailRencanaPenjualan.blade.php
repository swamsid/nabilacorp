@foreach($d_sales_plan->d_salesplan_dt as $detail)
<tr class="detail{{$detail->m_item->i_id}}">
   <td>
      <input style="width:100%" type="hidden" name="sd_item[]" value="{{$detail->m_item->i_id}}">
      <input value="{{$detail->spdt_comp}}" type="hidden" name="comp[]">
      <div style="padding-top:6px">{{$detail->m_item->i_code}} - {{$detail->m_item->i_name}}</div>
   </td>
   <td>
     <input class="stock stock{{$detail->m_item->i_id}}" style="width:100%;text-align:right;border:none"  value="{{number_format($detail->s_qty+$detail->spdt_qty,0,',','.')}}"  readonly="">
   </td>
   <td style="display:none">
     <input class="jumlahAwal{{$detail->m_item->i_id}}" style="width:100%;text-align:right;border:none" name="jumlahAwal[]" value="{{number_format($detail->spdt_qty,0,',','.')}}" autocomplete="off">
   </td>
   <td><input onblur="validationForm();setQty(event,'fQty{{$detail->m_item->i_id}}')" onclick="setAwal(event,'fQty{{$detail->m_item->i_id}}')" onkeyup="hapus(event,'{{$detail->m_item->i_id}}');validationForm();hitungTotalPerItem('{{$detail->m_item->i_id}}')" class="jumlah fQty{{$detail->m_item->i_id}}" style="width:100%;text-align:right;border:none" name="sd_qty[]" value="{{number_format($detail->spdt_qty,0,',','.')}}" autocomplete="off"></td>
   <td>
      <div style="padding-top:6px">{{$detail->satuan}}</div>
   </td>
   <td><input class="harga{{$detail->m_item->i_id}} alignAngka" style="width:100%;border:none" name="spdt_price[]" value="{{number_format($detail->m_item->i_price,0,',','.')}}"" readonly></td>
  
   <td align="right">
     <script>
          document.write(
               get_currency({{ $detail->subtotal }})
          );
     </script>
     
   </td>
   <td>
      <button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusButton('{{$detail->m_item->i_id}}')"><i class="fa fa-trash-o"></i></button>
   </td>
</tr>
@endforeach
<script type="text/javascript">
   tamp= [];
   hapusSalesDt=[];
</script>