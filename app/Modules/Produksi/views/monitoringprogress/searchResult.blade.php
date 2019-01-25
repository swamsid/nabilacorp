<?php $x=0; ?>
                  @if(count($plan) > 0)
                    <input type="text" class="hidden" name="pp_item" id="pp_item" value="{{$id}}">
                    @foreach($plan as $pn)
                      
                      @if($pn->pp_isspk == 'N')
                      <tr class="exc">
                        <td> 
                          
                          <input id="tanggal{{$x}}" class="form-control datepicker3" name="tanggal{{$x}}" type="text" value="{{ date('d-m-Y', strtotime($pn->pp_date)) }}">
                        </td>
                        <td>
                          <input name="pp_qty{{$x}}" type="number" class="form-control" style="text-align:right;"
                          value="{{ $pn->pp_qty }}">
                        </td>
                        <td>
                          <i class="fa fa-times"></i>  Rencana
                        </td>
                        <td>
                          <!--   -->
                          <button type="button" class="btn btn-danger hapus" onclick="hapusPlan(this)"><i class="glyphicon glyphicon-minus"></i></button>
                        </td>
                      </tr>
                      <?php $x++; ?>
                      @endif
                      
                      @if($pn->pp_isspk == 'Y')
                      <tr>
                        <td> 
                          <input id="tanggal" class="form-control datepicker3" name="tanggal" type="text" value="{{ date('d-m-Y', strtotime($pn->pp_date)) }}" readonly="">
                        </td>
                        <td>
                          <input name="pp_qty" type="number" class="form-control" style="text-align:right;"
                          value="{{ $pn->pp_qty }}" readonly="">
                        </td>
                        <td>
                          <i class="fa fa-check"></i>  SPK
                        </td>
                        <td>
                         <!--  <button type="button" class="btn btn-info" onclick="tambahPlan()"><i class="glyphicon glyphicon-plus"></i></button>  -->
                        </td>
                      </tr>
                      @endif
                      
                      @if($pn->pp_isspk == 'P')
                      <tr>
                        <td> 
                          <input id="tanggal" class="form-control datepicker3" name="tanggal" type="text" value="{{ date('d-m-Y', strtotime($pn->pp_date)) }}" readonly="">
                        </td>
                        <td>
                          <input name="pp_qty" type="number" class="form-control" style="text-align:right;"
                          value="{{ $pn->pp_qty }}" readonly="">
                        </td>
                        <td>
                          <i class="fa fa-check"></i>  Produksi
                        </td>
                        <td>
                          <button type="button" class="btn btn-info" onclick="tambahPlan()"><i class="glyphicon glyphicon-plus"></i></button> 
                        </td>
                      </tr>
                      @endif
                      
                    @endforeach

                  @else
                    <?php $x = 1; ?>
                    <tr class="exc">
                      <input type="text" class="hidden" name="pp_item" id="pp_item" value="{{$id}}">
                      <td><input type="text" name="tanggal0" class="form-control datepicker3" value="{{ date('d-m-Y') }}"></td>
                      <td><input name="pp_qty0" type="number" class="form-control input-sm" style="text-align:right;">
                      </td>
                      <td>
                        <i class="fa fa-times"></i>  Rencana
                      </td>
                      <td>
                          <button type="button" class="btn btn-danger hapus" onclick="hapusPlan(this)"><i class="glyphicon glyphicon-minus"></i></button>
                        </td>
                    </tr>
                  @endif
                  <input type="text" class="hidden" name="rowPlan" id="rowPlan" value="{{$x}}">