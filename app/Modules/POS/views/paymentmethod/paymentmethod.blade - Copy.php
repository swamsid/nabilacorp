

<tr >
      <td>
        <select style="width:90%" class="" name="sp_method[]" id="cara{{$jumlah}}" >
            @foreach($paymentmethod as $pm)
            <option value="{{$pm->pm_id}}" >{{$pm->pm_name}}</option>                                
            @endforeach
        </select>              
      </td>
      <td>
        <input  class="f2 nominal alignAngka nominal{{$jumlah}}" style="width:90%" type="" name="sp_nominal[]" id="nominal" onkeyup="addf2(event);totalPembayaran('nominal{{$jumlah}}');rege(event,'nominal{{$jumlah}}')"  onblur="setRupiah(event,'nominal{{$jumlah}}')" onclick="setAwal(event,'nominal{{$jumlah}}')" autocomplete="off">




      </td>
      <td class="hutang{{$jumlah}}" style="display: none;">
        <input  style="width:90%" type="" name="" value="{{date('d-m-Y')}}">
      </td>
      <td>
        <button type="button" class="btn btn-sm btn-danger hapus" onclick="hapusPayment(this)"  ><i class="fa fa-trash-o"></i></button>
      </td>
    </tr>

<!-- <input class="add1 nominal alignAngka" style="width:90%" type="" name="sp_nominal[]" id="nominal" onkeyup="totalPembayaran('nominal');rege(event,'nominal')"  onblur="setRupiah(event,'nominal')" onclick="setAwal(event,'nominal')"> -->

