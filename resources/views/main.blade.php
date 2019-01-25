<!DOCTYPE html>
<html>
     <head>
      
        @include('layouts._head')
        @yield('extra_styles')
     </head>
     <body class="no-skin">

      {{-- Modul Keuangan --}}
        @if(keuangan::periode()->emptyData() || keuangan::periode()->missing())
            <div class="ez-popup" id="trial-popup">
                <div class="layout sm">
                    <div class="top-popup" style="background: none;">
                        <span class="title">
                            @if(keuangan::periode()->emptyData())
                                Periode Keuangan Belum Dibuat
                            @elseif(keuangan::periode()->missing())
                                Periode Keuangan Telah Memasuki Bulan Baru
                            @endif
                        </span>
                    </div>

                    @if(keuangan::periode()->emptyData())
                        <form action="{{ route('modul_keuangan.periode.save') }}" method="POST" id="modul_keuangan_form_periode">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                            <div class="content-popup">
                                <div class="col-md-12" style="margin-top: 0px;">
                                    Sistem Kami Tidak Bisa Menemukan Satu Pun Periode Keuangan Yang Ada. Agar Semua Proses Pada Aplikasi Ini Dapat Berjalan Tanpa Kendala, Anda Harus Membuat Satu Periode Keuangan Sesuai Dengan Bulan Pembukaan (cut off) Yang Diinginkan. Nantinya Anda Juga Harus Membuat Periode Keuangan Baru Setiap Bulannya. 
                                </div>

                                <div class="col-md-12 text-center" style="margin-top: 25px; background: #eee; padding: 20px 0px; border-radius: 10px;">
                                    <div class="row">
                                        <div class="col-md-1 offset-1" style="background: none; padding-left: 50px;">
                                            <i class="fa fa-calendar" style="font-size: 24pt;"></i>
                                        </div>

                                        <div class="col-md-3" style="padding: 7px 0px 0px 0px; font-style: italic; font-weight: bold">
                                            Pilih Bulan Cut Off
                                        </div>

                                        <div class="col-md-7" style="padding: 7px 0px 0px 20px; font-style: italic; font-weight: bold;">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <select class="form-control modul-keuangan" name="bulan">
                                                        @for($a = 0; $a < date('m'); $a++)
                                                            <option value="{{ getBulan()[$a]['value'] }}">{{ getBulan()[$a]['nama'] }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-md-1" style="padding: 2px 0px;"><i class="fa fa-minus"></i></div>

                                                <div class="col-md-4">
                                                    <select class="form-control modul-keuangan" name="tahun">
                                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-left" style="margin-top: 5px; border-top: 1px solid #eee; padding-top: 15px;">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="loader" style="display: none;" id="modul_keuangan_status_periode">
                                               <div class="loading"></div> &nbsp; <span>Sedang Memproses Periode Baru. Harap Tunggu...</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary btn-sm" id="modul_keuangan_proses_periode">Proses Periode</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @elseif(keuangan::periode()->missing())
                        <form action="{{ route('modul_keuangan.periode.save') }}" method="POST" id="modul_keuangan_form_periode">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                            <div class="content-popup">
                                <div class="col-md-12" style="margin-top: 0px;">
                                    Sepertinya Periode Keuangan Telah Memasuki Bulan Baru. Anda Tidak Bisa Menggunakan Fitur-FItur Pada Sistem Sebelum Membuat Periode Baru Tersebut. Buat Sekarang ? 
                                </div>

                                <div class="col-md-12 text-center" style="margin-top: 25px; background: #eee; padding: 20px 0px;">
                                    <div class="row">
                                        <div class="col-md-1 offset-1" style="background: none; padding-left: 50px;">
                                            <i class="fa fa-calendar" style="font-size: 24pt;"></i>
                                        </div>

                                        <div class="col-md-3" style="padding: 7px 0px 0px 0px; font-style: italic; font-weight: bold">
                                            Periode baru
                                        </div>

                                        <div class="col-md-7" style="padding: 7px 0px 0px 20px; font-style: italic; font-weight: bold;">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <select class="form-control modul-keuangan" name="bulan">
                                                        <option value="{{ getBulan()[(date('n') - 1)]['value'] }}">{{ getBulan()[(date('n') - 1)]['nama'] }}</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-1" style="padding: 2px 0px;"><i class="fa fa-minus"></i></div>

                                                <div class="col-md-4">
                                                    <select class="form-control modul-keuangan" name="tahun">
                                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-left" style="margin-top: 5px; border-top: 1px solid #eee; padding-top: 15px;">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="loader" style="display: none;" id="modul_keuangan_status_periode">
                                               <div class="loading"></div> &nbsp; <span>Sedang Memproses Periode Baru. Harap Tunggu...</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary btn-sm" id="modul_keuangan_proses_periode">Proses Periode</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        @endif

     @include('layouts._sidebar')
       <div class="main-content">
            <div class="main-content-inner">  
               @yield('content')
            </div>
       </div>  
        @include('layouts._scripts')
        @yield('extra_scripts')
    </body>
</html>
