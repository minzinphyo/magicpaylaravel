@extends('frontend.layouts.app')

@section('title','Profile');
@section('content')
  <div class="account">
      <div class="profile mb-3">
        <img src="https://ui-avatars.com/api/?background=5842E3&color=fff&name={{$user->name}}" alt="">
      </div>

      <div class="card mb-3">
          <div class="card-body pr-0">
              <div class="d-flex justify-content-between">
                  <span>Username</span>
                  <span class="mr-3">{{$user->name}}</span>
              </div>
              <hr>
              <div class="d-flex justify-content-between">
                  <span>Phone</span>
                  <span class="mr-3">{{$user->phone}}</span>
              </div>
              <hr>
              <div class="d-flex justify-content-between">
                  <span>Email</span>
                  <span class="mr-3">{{$user->email}}</span>
              </div>
          </div>
      </div>

      <div class="card">
        <div class="card-body pr-0">
            <a href="{{route('update-password')}}" class="d-flex justify-content-between">
                <span>Update Password</span>
                <span class="mr-3"><i class="fas fa-angle-right"></i></span>
            </a>
            <hr>
            <a href="#" class="d-flex justify-content-between logout">
                <span>Logout</span>
                <span class="mr-3"><i class="fas fa-angle-right"></i></span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>

        </div>
      </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $(document).on('click','.logout',function(e){
           e.preventDefault();

           Swal.fire({
                title: 'Are you sure you want to logout?',
                showCancelButton: true,
                confirmButtonText: `Confirm`,
                reverseButtons: true,

            }).then((result) => {
             /* Read more about isConfirmed, isDenied below */
                 if (result.isConfirmed) {

                    document.getElementById('logout-form').submit();

                }
             });

          });
        })
    </script>
@endsection
