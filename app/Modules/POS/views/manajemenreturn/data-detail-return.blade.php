@foreach($sales as $data)
<tr>
  <td>
      <input  name="i_name[]" readonly class="form-control " value="{{$data->i_name}}">
      <input  name="dsrdt_item[]" readonly type="hidden" class="form-control text-right" value="{{$data->i_id}}">
  </td>
  <td>
      <input  name="dsrdt_qty[]" type="hidden" value="{{$data->sd_qty}}">
      <input  name="dsrdt_qty_confirm[]" class="form-control text-right qty-item" value="{{$data->sd_qty}}">
  </td>
  <td>
      <input  name="s_name[]" class="form-control text-right" value="{{$data->s_name}}" readonly>
  </td>
  <td>
      <input name="dsrdt_price_text[]" readonly class="form-control text-right harga-item" value="Rp. {{number_format($data->sd_price,2,',','.')}}">
      <input name="dsrdt_price[]" type="hidden" value="{{ $data->sd_price }}">
  </td>
 
  <td>
      <input name="dsrdt_price_disc_text[]" readonly class="form-control text-right harga-item" value="Rp. {{number_format($data->sd_price_disc,2,',','.')}}">
      <input name="dsrdt_price_disc[]" type="hidden" value="{{ $data->sd_price_disc }}">
  </td>
 
  
  <td>
    <input  name="dsrdt_total[]" readonly class="form-control text-right totalHarga totalNet" value="Rp. {{number_format($data->sd_total,2,',','.')}}">
  </td>
  <td>
        @if($metode=='TB')
            <div class="text-center">
              <select class="form-control" name="dsrdt_description[]">
                <option value="" selected>- pilih -</option>
                <option value="Rusak">Rusak</option>
              </select>
            </div>
        @else
            <div class="text-center">
              <select class="form-control" name="dsrdt_description[]">
                <option value="" selected>- pilih -</option>
                <option value="Kelebihan">Kelebihan</option>
                <option value="Rusak">Rusak</option>
              </select> 
            </div>
        @endif
  </td>
</tr>
@endforeach