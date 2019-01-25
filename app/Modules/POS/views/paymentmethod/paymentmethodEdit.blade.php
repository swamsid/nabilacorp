


@foreach($data['sales_pm'] as $in => $s_pm)
<tr >
      <td>
        <input type="hidden" name="sp_date[]" id="sp_date" value="{{$s_pm->sp_date}}">
        <select style="width:90%" class="minu mx" name="sp_method[]" id="cara{{$in+1}}" >
            @foreach($data['pm'] as $pm)
            <option value="{{$pm->pm_id}}" @if($pm->pm_id==$s_pm->sp_method) selected="" @endif>{{$pm->pm_name}}</option>
            @endforeach
        </select>              
      </td>
      <td>
        <input  class="minu mx f2 nominal alignAngka nominal{{$in+1}}" style="width:90%" type="" name="sp_nominal[]" id="nominal" value="{{number_format($s_pm->sp_nominal,0,',','.')}}"
         onkeyup="hapusPayment(event,this);addf2(event);totalPembayaran('nominal{{$in+1}}');rege(event,'nominal{{$in+1}}')"  onblur="setRupiah(event,'nominal{{$in+1}}')" onclick="setAwal(event,'nominal{{$in+1}}')" autocomplete="off">
      </td>
      <td class="hutang{{$in+1}}" style="display: none;">
        <input  style="width:90%" type="" name="" value="{{date('d-m-Y')}}">
      </td>
      <td>        
        <button type="button" class="btn btn-sm btn-danger hapus" onclick="btnHapusPayment(this)"  disabled=""><i class="fa fa-trash-o"></i></button>
      </td>
    </tr>
@endforeach
<!-- <input class="add1 nominal alignAngka" style="width:90%" type="" name="sp_nominal[]" id="nominal" onkeyup="totalPembayaran('nominal');rege(event,'nominal')"  onblur="setRupiah(event,'nominal')" onclick="setAwal(event,'nominal')"> -->