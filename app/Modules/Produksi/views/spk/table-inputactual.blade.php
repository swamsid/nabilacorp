<!-- detail order-->

<div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
     style="margin-bottom: 20px; padding-bottom:20px;padding-top:20px; ">

    <div class="col-md-4 col-sm-3 col-xs-12">
        <div class="">
            <label class="tebal">Berat Adonan :</label>
        </div>
    </div>
    <div class="col-md-6 col-sm-3 col-xs-12">
        <div class="form-group">
            @if($actual == null)
                <input class="form-control text-right" type="number" name="ac_adonan" id="ac_adonan"
                       value="">
            @else
                <input class="form-control text-right" type="number" name="ac_adonan" id="ac_adonan"
                       value="{{$actual->ac_adonan}}">
            @endif

        </div>
    </div>
    <div class="col-md-2 col-sm-3 col-xs-12">
        <div class="form-group">
            <input class="form-control" readonly type="text" name="" id=""
                   value="KG">
        </div>
    </div>

    <div class="col-md-4 col-sm-3 col-xs-12">
        <div class="">
            <label class="tebal">Berat Kriwilan :</label>
        </div>
    </div>
    <div class="col-md-6 col-sm-3 col-xs-12">
        <div class="form-group">
            @if($actual == null)
                <input class="form-control text-right" type="number" name="ac_kriwilan" id="ac_kriwilan"
                       value="">
            @else
                <input class="form-control text-right" type="number" name="ac_kriwilan" id="ac_kriwilan"
                       value="{{$actual->ac_kriwilan}}">
            @endif
        </div>
    </div>
    <div class="col-md-2 col-sm-3 col-xs-12">
        <div class="form-group">
            <input class="form-control" readonly type="text" name="" id=""
                   value="KG">
        </div>
    </div>

    <div class="col-md-4 col-sm-3 col-xs-12">
        <div class="">
            <label class="tebal">Berat Sampah :</label>
        </div>
    </div>
    <div class="col-md-6 col-sm-3 col-xs-12">
        <div class="form-group">
            @if($actual == null)
                <input class="form-control text-right" type="number" name="ac_sampah" id="ac_sampah"
                       value="">
            @else
                <input class="form-control text-right" type="number" name="ac_sampah" id="ac_sampah"
                       value="{{$actual->ac_sampah}}">
            @endif
        </div>
    </div>
    <div class="col-md-2 col-sm-3 col-xs-12">
        <div class="form-group">
            <input class="form-control" readonly type="text" name="" id=""
                   value="KG">
        </div>
    </div>

</div>


<div class="modal-footer">
    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="saveActual({{$spk->spk_id}})">Final</button>
</div>


<!-- end detail order-->
