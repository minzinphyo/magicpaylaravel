@extends('backend.layouts.app')

@section('title','Users')
@section('user-active','mm-active')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Users</div>
        </div>
    </div>
</div>


<div class="pt-3">
   <a href="{{route('admin.user.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create User</a>
</div>

<div class="content py-3">
    <div class="card">
        <div class="card-body">
                <table class="table responsive table-bordered Datatable" width="100%">
                    <thead>
                        <tr class="bg-light">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Ip</th>
                            <th>User Agent</th>
                            <th>Login at</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead><tbody>

                    </tbody>
                </table>



        </div>
    </div>
</div>

@endsection

@section('script')
    <script>

      $(document).ready(function() {
         var table = $('.Datatable').DataTable({

            processing: true,
            responsive: true,
            serverSide: true,
            scrollX: '100%',
            ajax: "/admin/user/datatable/ssd",

            columns: [
                {
                    data: "name",
                    name: "name",
                    width: '15%', // You can define each column width in the table



                },

                {
                    data: "email",
                    name: "email",
                    width: '15%', // You can define each column width in the table



                },

                {
                    data: "phone",
                    name: "phone",
                    width: '15%', // You can define each column width in the table

                },
                {
                    data: "ip",
                    name: "ip",
                    width: '15%', // You can define each column width in the table


                },

                {
                    data: "user_agent",
                    name: "user_agent",
                    width: '15%', // You can define each column width in the table

                },

                {
                    data: "login_at",
                    name: "login_at",
                    width: '15%',
                },

               {
                        name: 'created_at.timestamp',
                        data: {
                            _: 'created_at.display',
                            sort: 'created_at.timestamp'
                        },
                        width: '15%',


                },

                /*{
                    data: "created_at",
                    name: "created_at",
                    width: '15%', // You can define each column width in the table


                },*/


                {
                    data: "action",
                    name: "action",
                    width: '15%', // You can define each column width in the table


                },


            ],
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 3, 4, 6 ] },
                { "bSearchable": false, "aTargets": [ 3, 4, 6 ] }
            ],
            /*
                "columnDefs": [ {
            "targets": "no-sort",
            "searchable": false
            } ]
            */

            //order: [[5, "desc"]]

          });
        });

       $(document).on('click','.delete',function(e){
           e.preventDefault();

           var id = $(this).data('id');

           Swal.fire({
                title: 'Are you sure you want to delete?',

                showCancelButton: true,
                confirmButtonText: `Confirm`,

            }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/user/' + id,
                    type: 'DELETE',
                    success : function(){
                        location.reload();
                    }
                })
            }
        })

       })

    </script>
@endsection

