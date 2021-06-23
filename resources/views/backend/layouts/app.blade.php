<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

<link href="{{asset('backend/css/main.css')}}" rel="stylesheet">
<link href="{{asset('backend/css/style.css')}}" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">

@yield('extra_css')

</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

        @include('backend.layouts.header')

           <div class="app-main">

                @include('backend.layouts.sidebar')

                <div class="app-main__outer">
                    <div class="app-main__inner">
                        @yield('content')
                    </div>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-left">
                                    <span>Copyright {{date('Y')}}. All right reserved by Magic Pay</span>
                                </div>
                                <div class="app-footer-right">
                                    <span>Developed by Min Zin Phyo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
<script src="{{asset('backend/js/main.js')}}"></script></body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

{{--Sweet Alert2--}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){

        let token = document.head.querySelector('meta[name="csrf-token"]');
        if(token){
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
        }
        $('.back-btn').on('click',function(){
            window.history.go(-1);
            return false;
        })
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })

    @if (session('create'))
        Toast.fire({
          icon: 'success',
          title: "{{session('create')}}"
        })
    @endif

</script>

@yield('script')
</html>
