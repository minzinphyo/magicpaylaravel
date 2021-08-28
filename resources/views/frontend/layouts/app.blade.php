<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!--Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <!--Custom Css-->
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">

    <!--Google fonts(Open sans)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    @yield('extra_css')

</head>
<body>
    <div id="app">
        <div class="header-menu">
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-2 text-center">
                            @if (!request()->is('/'))
                                <a href="#" class="back-btn">
                                   <i class="fas fa-angle-left"></i>
                                </a>
                            @endif
                        </div>
                        <div class="col-8 text-center">

                                <h3>@yield('title')</h3>

                        </div>
                        <div class="col-2 text-center">
                            <a href="{{url('notification')}}">
                                <i class="fas fa-bell"></i>
                                <span class="badge badge-pill badge-danger unread_noti_count">{{$unread_noti_count}}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="d-flex row justify-content-center">
                <div class="col-md-8">
                    @yield('content')
                </div>
            </div>

        </div>

        <div class="bottom-menu">

            <a href="" class="scan-tab">
                <div class="inside">
                    <i class="fas fa-qrcode"></i>
                </div>
            </a>

            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-3 text-center">
                            <a href="{{route('home')}}">
                                <i class="fas fa-home"></i>
                                <p>Home</p>
                            </a>
                        </div>
                        <div class="col-3 text-center">
                            <a href="{{route('wallet')}}">
                                <i class="fas fa-wallet"></i>
                                <p>Wallet</p>
                            </a>
                        </div>
                        <div class="col-3 text-center">
                            <a href="{{url('transaction')}}">
                                <i class="fas fa-exchange-alt"></i>
                                <p>Transaction</p>
                            </a>
                        </div>
                        <div class="col-3 text-center">
                            <a href="{{route('profile')}}">
                                <i class="fas fa-user"></i>
                                <p>Profile</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
            integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    {{--Sweet Alert2--}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{--Paginate Scroll--}}
    <script src="{{asset('js/jscroll.min.js')}}"></script>

    <script src="{{asset('js/qr-scanner.umd.min.js')}}"></script>

    {{-- Date Range Picker --}}
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function(){
            let token = document.head.querySelector('meta[name="csrf-token"]');
            if(token){
                 $.ajaxSetup({
                 headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
                }
            });
         }
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

    @if (session('update'))
        Toast.fire({
          icon: 'success',
          title: "{{session('update')}}"
        })
    @endif

    $('.back-btn').on('click',function(e){
        e.preventDefault();
        window.history.go(-1);
        return false;
    })

    </script>

    @yield('scripts')
</body>
</html>
