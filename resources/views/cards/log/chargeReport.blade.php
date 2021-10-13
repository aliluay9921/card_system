@extends('layouts.app', ['title' => __('Cards')])
@section('report')
    text-primary
@endsection
@section('content')
    @include('users.partials.header',
    [
    'title' => __('') ,
    'class' => 'col-lg-12'
    ]
    )
    <link rel="dns-prefetch" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-transparent ">
                    <div class="card-header  ">
                        <div class="row px-3">

                            <div class="col-md-9 my-auto  "></div>
                            <div class="col-md-3 text-right">
                                <h2 class="display-4  ">تقرير البيع</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <div class="table-responsive w-100">
                            <table id="cardTable" class="table table-bordered  table-hover w-100">
                                <thead class="bg-gradient-secondary text-darker w-100">
                                    <tr>
                                        <th class="text-center ">رقم العمليه</th>
                                        <th class="text-center ">اسم المستخدم</th>
                                        <th class="text-center ">رقم هاتف المستخدم</th>
                                        <th class="text-center "> رقم هاتف المستلم</th>
                                        <th class="text-center "> قيمة التعئبة</th>
                                        <th class="text-center ">المبلغ</th>
                                        <th class="text-center ">تاريخ العملية والوقت</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center w-100"></tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
    <style>
        .paginate_button {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            color: #fff !important;
            background-color: #337ab7;
            border-color: #337ab7;

        }

        .current {
            color: #fff !important;
            background-color: #17a2b8 !important;
            border-color: #17a2b8 !important;
        }

        input {
            -webkit-transition: all 0.30s ease-in-out;
            -moz-transition: all 0.30s ease-in-out;
            -ms-transition: all 0.30s ease-in-out;
            -o-transition: all 0.30s ease-in-out;
            outline: none;
            padding: 10px 5px 10px 10px;
            margin: 5px 1px 3px 0px;
            border: 1px solid #DDDDDD;
        }

        input:focus {
            box-shadow: 0 0 5px rgba(81, 203, 238, 1);
            padding: 10px 5px 10px 10px;
            margin: 5px 1px 3px 0px;
            border: 1px solid rgba(81, 203, 238, 1);
        }

    </style>

    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js">
    </script>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('#cardTable').DataTable({
                processing: true,
                serverSide: true,
                retrieve: true,
                stateSave: true,
                "pagingType": "first_last_numbers",
                ajax: '{{ route('log.datatable_cahrge_balance') }}',
                columns: [{
                        "data": 'id',
                        "name": "id",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "user.user_name",
                        'name': "user.user_name",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "user.phone",
                        'name': "user.phone",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "phone_number",
                        'name': "phone_number",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "amounts",
                        "name": "amounts",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "sale_price",
                        "name": "sale_price",
                        orderable: true,
                        searchable: true
                    },

                    {
                        "data": "created_at",
                        "name": "created_at",
                        orderable: true,
                        searchable: true
                    },
                ],
            });


        });
    </script>

@endsection
