    <script src="{{ asset ('assets/script/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset ('assets/script/moment.min.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.dataTables.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery-ui.js') }}"></script>
    <script src="{{ asset ('assets/script/highcharts.js') }}"></script>
    <script src="{{ asset ('assets/script/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset ('assets/script/bootstrap.min.js') }}"></script>
    <script src="{{ asset ('assets/script/bootstrap-hover-dropdown.js') }}"></script>
    <script src="{{ asset ('assets/script/html5shiv.js') }}"></script>
    <script src="{{ asset ('assets/script/respond.min.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.cookie.js') }}"></script>
    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
    <script src="{{ asset ('assets/script/custom.min.js') }}"></script>
    <script src="{{ asset ('assets/script/accounting/accounting.js') }}"></script>   
    <script src="{{ asset ('assets/script/jquery.menu.js') }}"></script>
    <script src="{{ asset ('assets/script/pace.min.js') }}"></script>
    <script src="{{ asset ('assets/script/holder.js') }}"></script>
    <script src="{{ asset ('assets/script/responsive-tabs.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.flot.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.flot.tooltip.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.flot.fillbetween.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset ('assets/script/zabuto_calendar.min.js') }}"></script>
    <script src="{{ asset ('assets/script/index.js') }}"></script>
    <script src="{{ asset ('assets/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset ('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset ('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset ('assets/bootstrap-live-search/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset ('assets/sliptree-multiselect/bootstrap-tokenfield.js') }}"></script>
    <!--LOADING SCRIPTS FOR CHARTS-->
    <script src="{{ asset ('assets/script/data.js') }}"></script>
    <script src="{{ asset ('assets/script/drilldown.js') }}"></script>
    <script src="{{ asset ('assets/script/exporting.js') }}"></script>
    <script src="{{ asset ('assets/script/highcharts-more.js') }}"></script>
    <script src="{{ asset ('assets/script/charts-highchart-pie.js') }}"></script>
    <script src="{{ asset ('assets/script/charts-highchart-more.js') }}"></script>
    <script src="{{ asset ('assets/izi-toast/js/iziToast.js') }}"></script>
    <!--CORE JAVASCRIPT-->
    <script src="{{ asset ('assets/script/main.js') }}"></script>
    <script src="{{ asset ('assets/select2/select2.js') }}"></script>
    <!--CORE JAVASCRIPT-->
    <script src="{{ asset ('assets/rupiah-js/formatRp.js?v='.time()) }}"></script>
    <script src="{{ asset ('assets/rupiah-js/formatQty.js?v='.time()) }}"></script>
    <script src="{{ asset('assets/script/jquery.maskMoney.js') }}"></script>
    <script src="{{ asset('assets/jquery-validation.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/accounting/accounting.min.js') }}"></script>
    <script type="text/javascript">
        var baseUrl = '{{url('/')}}';
    </script>
    <script src="{{ asset('assets/inputmask/inputmask.jquery.js') }}"></script>
    <script src="{{ asset ('assets/script/timepicker.min.js') }}"></script>

    {{-- Script Modul Keuangan Wajib Di Main --}}

    {{-- ez popup script --}}
    <script src="{{asset('modul_keuangan/js/vendors/ez_popup_v_1_1/ez.popup.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#trial-popup').ezPopup('show', {
                closable: false,
            });

            @if(Session::has('message'))
                alert('{{ Session::get('message') }}');
            @endif

            $('#modul_keuangan_proses_periode').click(function(e){
                e.stopImmediatePropagation();

                $(this).attr('disabled', 'disabled');
                $('#modul_keuangan_status_periode').fadeIn(200);
                $('#modul_keuangan_form_periode').submit();
            })
        })
    </script>
    
    <script type="text/javascript">

        function numberOnly(){
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }

        }
        $(document).ready(function(){
            var extensions = {
         "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    $('.data-table').dataTable({
          "responsive":true,

          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Cari Data",
            "emptyTable": "Tidak ada data",
            "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>',
            "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            "infoEmpty": "",
            "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya",
                 }
          }

        });
            $("input[type='number']").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
        });

     var dataTableLanguage = {
           "emptyTable": "Tidak ada data",
           "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Baris",
           "sSearch": 'Pencarian..',
           "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
           "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
             }
          }

    function regeneratedSession(){
        $.ajax({
            url: baseUrl+'/session-set-comp/'+$('.mem_comp').val(),
            type: 'get',
            timeout: 5000,
            success: function(response){
                location.reload();
            }
        })
    }

    </script>

    <script>
    function myFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("nav-search");
        filter = input.value.toLowerCase();
        ul = document.getElementById("side-menu");
        li = ul.getElementsByTagName("li");
        button = document.getElementById('btn-reset');
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toLowerCase().indexOf(filter) > -1) {

                li[i].style.display = "";

            } else {

                li[i].style.display = "none";

            }

        }
        
        if (input.value != 0 ) {
                button.classList.remove('hidden');
            } else {
                button.classList.add('hidden');
            }
            
        }

        function btnReset() {
            var input = document.getElementById("filterInput");
            input.value = null;
            input.focus();
        }

    // $('#side-menu').searchable({
    //     searchField: '#nav-search',
    //     selector: 'li',
    //     childSelector: '.submenu-title',
    //     show: function( elem ) {
    //         elem.slideDown(100);
    //     },
    //     hide: function( elem ) {
    //         elem.slideUp( 100 );
    //     }
    // })

        $('#logut_btn').click(function(event){
            event.preventDefault();
            iziToast.question({
                timeout: 20000,
                close: true,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Logout?',
                message: 'Apakah anda yakin?',
                position: 'center',
                buttons: [
                    ['<button><b>Ya</b></button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        window.location.href = $('#logut_btn').attr('href');
             
                    }, true],
                    ['<button>Tidak</button>', function (instance, toast) {
             
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
             
                    }],
                ],
                onClosing: function(instance, toast, closedBy){
                    console.info('Closing | closedBy: ' + closedBy);
                },
                onClosed: function(instance, toast, closedBy){
                    console.info('Closed | closedBy: ' + closedBy);
                }
            });
        });
    </script>