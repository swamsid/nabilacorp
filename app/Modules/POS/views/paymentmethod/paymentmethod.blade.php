'<tr><td><select style="width:90%" class="minu mx" name="sp_method[]" >@foreach($paymentmethod as $pm)<option value="{{$pm->pm_id}}">{{$pm->pm_name}}</option>@endforeach</select></td>'
      