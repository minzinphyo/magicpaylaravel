@extends('backend.layouts.app')

@section('title','Wallets')
@section('wallet-active','mm-active')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-wallet icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Wallets</div>
        </div>
    </div>
</div>

<div class="pt-3">
    <a href="{{url('admin/wallet/add/amount')}}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add Amount</a>
    <a href="{{url('admin/wallet/reduce/amount')}}" class="btn btn-danger"><i class="fas fa-minus-circle"></i> Reduce Amount</a>
</div>


<div class="content py-3">
    <div class="card">
        <div class="card-body">
                <table class="table responsive table-bordered Datatable" width="100%">
                    <thead>
                        <tr class="bg-light">
                            <th>Account Number</th>
                            <th>Account Person</th>
                            <th>Amount (MMK)</th>
                            <th>Created at</th>
                            <th>Update at</th>

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
            ajax: "/admin/wallet/datatable/ssd",

            columns: [
                {
                    data: "account_number",
                    name: "account_number",
                    width: '20%', // You can define each column width in the table



                },

                {
                    data: "account_person",
                    name: "account_person",
                    width: '25%', // You can define each column width in the table



                },

                {
                    data: "amount",
                    name: "amount",
                    width: '20%', // You can define each column width in the table
                    className: "text-right"

                },

                {
                        name: 'created_at.timestamp',
                        data: {
                            _: 'created_at.display',
                            sort: 'created_at.timestamp'
                        },
                        width: '15%',
                        className: "text-center"


                },

                {
                        name: 'updated_at.timestamp',
                        data: {
                            _: 'updated_at.display',
                            sort: 'updated_at.timestamp'
                        },
                        width: '15%',
                        className: "text-center"


                },


            ],

            order: [[4, "desc"]]

          });
        });

    </script>
@endsection

