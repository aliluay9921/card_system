@extends('layouts.app', ['title' => __('Cards')])
@section('card')
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
                            <div class="col-md-3 text-right" style="margin-left: 900px">
                                <h2 class="display-4  ">جدول البطاقات</h2>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="table-responsive w-100">
                            <a href="{{ route('refresh_api_card') }}"
                                class="btn btn-primary text-white  float-right">اعادة تحميل البيانات </a>
                            <table id="cardTable" class="table table-bordered  table-hover">
                                <thead class="bg-gradient-secondary text-darker">
                                    <tr>
                                        <th class="text-center ">نوع البطاقة</th>
                                        <th class="text-center ">سعر الشراء</th>
                                        <th class="text-center ">سعر البيع</th>
                                        <th class="text-center ">تفعيل</th>
                                        <th class="text-center ">تاريخ الاصدار</th>
                                        <th class="text-center ">الصور</th>
                                        <th class="text-center ">العمليات</th>

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

        .dataTables_length {
            width: fit-content;
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
                ajax: '{{ route('card_api.datatable') }}',
                columns: [{
                        "data": "type_card",
                        "name": "type_card",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "buy_card",
                        "name": "buy_card",
                        orderable: true,
                        searchable: true
                    }, {
                        "data": "sale_card",
                        "name": "sale_card",
                        orderable: true,
                        searchable: true
                    },

                    {
                        "data": "active",
                        "name": "active",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "created_at",
                        "name": "created_at",
                        orderable: true,
                        searchable: true
                    },
                    {
                        "data": "image",
                        "name": "image",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }


                ],
            });


        });
        $('#cardTable').on('click', '.btn-delete[data-remote]', function(e) {

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    method: '_DELETE',
                    submit: true
                }
            }).always(function(data) {
                $('#cardTable').DataTable().draw(false);
            });
        });

        function filter(status) {
            var table = $('#cardTable').DataTable();
            table.search(status).draw();
        }
    </script>

@endsection
