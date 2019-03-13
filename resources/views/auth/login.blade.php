@extends('layouts.app')

@section('content')
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{asset('assets/login-v18/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendors/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendors/animate/animate.css')}}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendors/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendors/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendors/select2/select2.min.css')}}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendors/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/css/main.css')}}">

    <style type="text/css">
        select.input100#akses {
            border: none;
        }
    </style>
<!--===============================================================================================-->

<body style="background-color: #666666;">
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100" id="parallax-js">
                <form class="login100-form validate-form">
                    {{ csrf_field() }}
                    <span class="login100-form-title p-b-43">
                        Nabila Bakery
                    </span>
                    
                    
                    <div class="wrap-input100 validate-input" data-validate = "Username / E-mail is required">
                        <input class="input100" type="text" name="username" id="email" autofocus>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Username / E-mail</span>
                    </div>
                    
                    
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" name="password">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        
                        <select class="input100" name="akses" id="akses">
                            <option value="0">-- Pilih --</option>
                        @foreach(App\Modules\POS\model\m_machine::showMachine() as $data) 
                            <option value="{{$data->m_id}}">{{$data->m_name}}</option>
                        @endforeach
                        </select>
                        <span class="focus-input100"></span>
                        <span class="label-input100">Pilih Kasir</span>
                    </div>
                    
                    <div class="container-login100-form-btn">
                        <button type="button" class="login100-form-btn" onclick="loginUser()">
                            Login
                        </button>
                    </div>
                    
                    <div class="text-center p-t-46 p-b-20">
                        <span class="txt2">
                           {{date('Y')}} &copy; Created By
                        </span>
                    </div>

                    <div class="login100-form-social flex-c-m">
                        <a href="http://www.alamraya.co.id/" target="_blank" class="txt2 btn-link">Alamraya Sebar Barokah</a>
                    </div>
                </form>

                <div class="login100-more" data-depth="0.20">
                    <img src="{{asset('assets/img/bakery-bg1.jpg')}}">
                </div>
            </div>
        </div>
    </div>
    
    

    
    
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendors/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendors/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendors/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('assets/login-v18/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendors/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendors/daterangepicker/moment.min.js')}}"></script>
    <script src="{{asset('assets/login-v18/vendors/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendors/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/js/main.js')}}"></script>
    <script src="{{asset('assets/parallax-mouseposition/parallax.js')}}"></script>
</body>      
<script type="text/javascript">
    var baseUrl = '{{url('/')}}';
    $("#username").load("Auth/login", function(){
    $("#username").focus();
    });

    function loginUser(){
        var formInput=$('.login100-form').serialize();        
         $.ajax({
          url     :  baseUrl+'/login',
          type    : 'get', 
          data    :  formInput,
          dataType: 'json',
          success : function(response){    
                    if(response.status=='sukses'){
                        window.location = baseUrl+'/home';
                    }else if(response.status=='gagal'){
                        alert(response.data);

                    }
          },

          error: function(jqXHR, exception) {
            if (jqXHR.status === 0) {
                alert('Not connect.\n Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found. [404]');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error [500].');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error.\n' + jqXHR.responseText);
            }
        }


      });
    }
</script>
<script type="text/javascript">
    
        var particles_js = document.getElementById('parallax-js');

        var parallax = new Parallax(particles_js, {
            pointerEvents:true
        });

</script>
@endsection
