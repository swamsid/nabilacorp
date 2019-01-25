@extends('layouts.app')

@section('content')
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{asset('assets/login-v18/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendor/animate/animate.css')}}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-v18/vendor/daterangepicker/daterangepicker.css')}}">
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
            <div class="wrap-login100">
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
                        <!-- <input class="input100" type="password" name="password" name="password"> -->
                        <select class="input100" name="akses" id="akses">
                            <option value="0">Pilih Kasir</option>
                        @foreach(App\Modules\POS\model\m_machine::showMachine() as $data) 
                            <option value="{{$data->m_id}}">{{$data->m_name}}</option>
                        @endforeach
                        </select>
                        <span class="focus-input100"></span>
                        <!-- <span class="label-input100">Pilih Kasir</span> -->
                    </div>

                    <!-- <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>

                        <div>
                            <a href="#" class="txt1">
                                Forgot Password?
                            </a>
                        </div>
                    </div> -->
            

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
                        <!-- <a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
                            <i class="fa fa-facebook-f" aria-hidden="true"></i>
                        </a>

                        <a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a> -->
                    </div>
                </form>

                <div class="login100-more" style="background-image: url('assets/img/bakery-bg1.jpg');">
                </div>
            </div>
        </div>
    </div>
    
    

    
    
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('assets/login-v18/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendor/daterangepicker/moment.min.js')}}"></script>
    <script src="{{asset('assets/login-v18/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
    <script src="{{asset('assets/login-v18/js/main.js')}}"></script>

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
@endsection
