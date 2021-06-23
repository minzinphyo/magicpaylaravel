@extends('backend.layouts.app')

@section('title','Admin Users')
@section('admin-user-active','mm-active')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Admin Users</div>
        </div>
    </div>
</div>


<div class="pt-3">
   <a href="{{route('admin.admin-user.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Create Admin User</a>
</div>

<div class="content py-3">
    <div class="card">
        <div class="card-body">
                <table class="table responsive table-bordered Datatable" width="100%">
                    <thead>
                        <tr class="bg-light">
                            <th>Name</th>
                            <th>Email</th>
                            <th class="no-sort">Phone</th>
                            <th class="no-sort">Ip</th>
                            <th class="no-sort">User Agent</th>
                            <th class="no-sort">Date</th>
                            <th class="no-sort">Action</th>
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
            ajax: "/admin/admin-user/datatable/ssd",

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
                        name: 'created_at.timestamp',
                        data: {
                            _: 'created_at.display',
                            sort: 'created_at.timestamp'
                        },
                        width: '15%',



                },

                {
                    data: "action",
                    name: "action",
                    width: '20%', // You can define each column width in the table


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

            order: [[5, "desc"]]

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
                    url: '/admin/admin-user/' + id,
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

