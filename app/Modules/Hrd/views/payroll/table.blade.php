@extends('main')
@section('content')
<center>
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Payroll</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;HRD&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Payroll</li>
                    </ol>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="page-content fadeInRight">
                    <div id="tab-general">
                        <div class="row mbl">
                            <div class="col-lg-12">

                                            <div class="col-md-12">
                                                <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                                                </div>
                                            </div>

                            <ul id="generalTab" class="nav nav-tabs">
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Payroll</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive" >
                            <div id="alert-tab" class="tab-pane fade in active">
                            <div class="">
                           <div class="">
                 </div>
                 <!-- /.box-header -->
                 <div class="box-body">
                     <div>
                         <form class="form-horizontal" id="header">
                             <table id="" class="table table-striped">
                               <tbody>
                                   <tr>
                                         <td style="width:5%; padding-top: 0.4cm">Tanggal</td>
                                         <td style="width:8%;"><input disabled="" class="form-control" value="27"></td>
                                         <td style="width:5%; padding-top: 0.4cm">Bulan</td>
                                         <td style="width:8%;">
                                             <select class="form-control" id="cb_bulan" onchange="setNull()">
                                                 <option value="1">1</option>
                                                 <option value="2">2</option>
                                                 <option value="3">3</option>
                                                 <option value="4">4</option>
                                                 <option value="5">5</option>
                                                 <option value="6">6</option>
                                                 <option value="7">7</option>
                                                 <option value="8">8</option>
                                                 <option value="9">9</option>
                                                 <option value="10">10</option>
                                                 <option value="11">11</option>
                                                 <option value="12">12</option>
                                             </select>
                                         </td>
                                         <td style="width:5%; padding-top: 0.4cm">Tahun</td>
                                         <td style="width:10%;">
                                             <select class="form-control" id="cb_tahun" onchange="setNull()">
                                                 <option value="2017">2017</option>
                                                 <option value="2018">2018</option>
                                                 <option value="2019">2019</option>
                                                 <option value="2020">2020</option>
                                                 <option value="2021">2021</option>
                                                 <option value="2022">2022</option>
                                                 <option value="2023">2023</option>
                                                 <option value="2024">2024</option>
                                                 <option value="2025">2025</option>
                                                 <option value="2026">2026</option>
                                                 <option value="2027">2027</option>
                                                 <option value="2028">2028</option>
                                                 <option value="2029">2029</option>
                                                 <option value="2030">2030</option>
                                                 <option value="2031">2031</option>
                                                 <option value="2032">2032</option>
                                                 <option value="2033">2033</option>
                                                 <option value="2034">2034</option>
                                                 <option value="2035">2035</option>
                                                 <option value="2036">2036</option>
                                                 <option value="2037">2037</option>
                                                 <option value="2038">2038</option>
                                                 <option value="2039">2039</option>
                                                 <option value="2040">2040</option>
                                                 <option value="2041">2041</option>
                                                 <option value="2042">2042</option>
                                                 <option value="2043">2043</option>
                                                 <option value="2044">2044</option>
                                                 <option value="2045">2045</option>
                                                 <option value="2046">2046</option>
                                                 <option value="2047">2047</option>
                                                 <option value="2048">2048</option>
                                                 <option value="2049">2049</option>
                                                 <option value="2050">2050</option>
                                                 <option value="2051">2051</option>
                                                 <option value="2052">2052</option>
                                                 <option value="2053">2053</option>
                                                 <option value="2054">2054</option>
                                                 <option value="2055">2055</option>
                                                 <option value="2056">2056</option>
                                                 <option value="2057">2057</option>
                                                 <option value="2058">2058</option>
                                                 <option value="2059">2059</option>
                                                 <option value="2060">2060</option>
                                                 <option value="2061">2061</option>
                                                 <option value="2062">2062</option>
                                                 <option value="2063">2063</option>
                                                 <option value="2064">2064</option>
                                                 <option value="2065">2065</option>
                                                 <option value="2066">2066</option>
                                                 <option value="2067">2067</option>
                                                 <option value="2068">2068</option>
                                                 <option value="2069">2069</option>
                                                 <option value="2070">2070</option>
                                                 <option value="2071">2071</option>
                                                 <option value="2072">2072</option>
                                                 <option value="2073">2073</option>
                                                 <option value="2074">2074</option>
                                                 <option value="2075">2075</option>
                                                 <option value="2076">2076</option>
                                                 <option value="2077">2077</option>
                                                 <option value="2078">2078</option>
                                                 <option value="2079">2079</option>
                                                 <option value="2080">2080</option>
                                                 <option value="2081">2081</option>
                                                 <option value="2082">2082</option>
                                                 <option value="2083">2083</option>
                                                 <option value="2084">2084</option>
                                                 <option value="2085">2085</option>
                                                 <option value="2086">2086</option>
                                                 <option value="2087">2087</option>
                                                 <option value="2088">2088</option>
                                                 <option value="2089">2089</option>
                                                 <option value="2090">2090</option>
                                                 <option value="2091">2091</option>
                                                 <option value="2092">2092</option>
                                                 <option value="2093">2093</option>
                                                 <option value="2094">2094</option>
                                                 <option value="2095">2095</option>
                                                 <option value="2096">2096</option>
                                                 <option value="2097">2097</option>
                                                 <option value="2098">2098</option>
                                                 <option value="2099">2099</option>
                                                 <option value="2100">2100</option>
                                             </select>
                                         </td>
                                          <td>
                                             <button type="button" class="btn btn-md btn-info"  id="btn_tampilkan">Tampilkan</button>
                                             <button type="button" class="btn btn-md btn-primary"  id="edit" style="display: none">Edit</button>
                                             <button type="button" class="btn btn-md btn-primary"  id="perbarui" style="display: none">perbarui</button>
                                             <button type="button" class="btn btn-md btn-primary"  id="btn_simpan">Simpan</button>
                                             <button type="button" class="btn btn-md btn-danger" style="display: none;" id="hapus">Hapus</button>
                                             <button type="button" class="btn btn-md btn-success"  id="bayar">Bayar Pengajian</button>
                                         </td>
                                   </tr>
                               </tbody>
                             </table>
                         </form>
<table class="table  table-striped table-hover" cellspacing="0" width="100%">
    <tr>
        <th>
            Total Gaji
        </th>
        <td class="text-right"><input disabled="" id="" class="text-right form-control" value="" name="total_gaji" ><td>
            <input  name="" class="kedua">
        </tr>
        <tr>
        <th>
            Total Pajak
        </th>
        <td class="text-right"><input type="text" readonly="" id="" class=" text-right form-control " name="" value="" ><td>
        </tr>
</table>

<table id="data"  class="table  table-striped table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="display: none">id</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Kehadiran</th>
                                    <th>Gaji Pokok</th>
                                    <th>Tunjangan</th>
                                    <th>Gaji + Tunjangan - Potongan</th>
                                    <th>QPE</th>
                                    <th>K5</th>
                                    <th>PPH 21</th>
                                    <th>Total Gaji</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr>
                                    <td style="display: none"><input name="" value=""></td>
                                    <td></td>
                                    <td></td>
                                     <td >
                                    <input type="hidden" name="" value="">
                                    <input type="hidden" name="" value="">
                                    <input type="hidden" name="" value="">
                                    <input type="hidden" name="" value="">
                                    <input type="hidden" name="" value=""></td>
                                    <td class="text-right"> </td>

                                    <td>
                                                            <input type="hidden" name="tunjangan_jabatanN[]" value="">
                                                            <input type="hidden" name="tunjangan_kehadiranN[]" value="">
                                                            <input type="hidden" name="uang_makanN[]" value="">
                                    </td>

                                    <td class="text-right"><input type="hidden" name="" value=""> <span readonly="true" class=""> </span></td>

                                    <td class="text-right">
                                        <input type="hidden" name="" class="text-right " value="0">
                                        <input name="" readonly="true" onkeyup="" class="form-control text-right  " value="" >
                                    </td>
                                    <td class="text-right">
                                        <input type="hidden" name="" class="text-right k5N" value="0">
                                        <input name="" readonly="true" onkeyup="" class="form-control text-right  " value="" >
                                    </td>
                                     <td class="text-right">
                                        <input type="hidden" name="" class="text-right " value="0">
                                        <input name="" readonly="true" onkeyup="hitungpphN()" class="form-control text-right  "  value="" class="form-control text-right"  value="0" >
                                    </td>

                                    <td class="text-right"><input type="hidden" name="" class="" value=""> <input type="hidden" name="" class="" value=""> <span class=""><span></td>
                                </tr>
                            </tbody>
</table>
</center>
@endsection
