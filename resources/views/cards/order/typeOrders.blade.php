@extends('layouts.app')
@section('company')
    text-primary
@endsection
@section('content')
    @include('users.partials.header',
    [
    'title' => __('') ,
    'class' => 'col-lg-12'
    ]
    )

    <div class="container mt--7">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between ">
                        <a href="{{ route('order_type.create') }}" class="btn btn-primary">اضافه</a>
                        <b class="h2"> جدول انواع الحوالات</b>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-body ">
                        <table class="table">
                            <thead>
                                <tr class="text-center">

                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الاسم عربي</th>
                                    <th>رقم الهاتف</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($type_orders as $order_type)
                                    <tr class="text-center">
                                        <th>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="">
                                                @if ($order_type->active == 1)
                                                    <button type="submit" class="active_ordertype btn btn-danger "
                                                        offer_id="{{ $order_type->id }}">تعطيل</button>
                                                @else
                                                    <button offer_id="{{ $order_type->id }}"
                                                        class=" active_ordertype btn btn-success ">
                                                        تشغيل</button>
                                                @endif

                                                <a href="{{ route('order_type.edit', $order_type->id) }}" type="button"
                                                    class="btn btn-info">
                                                    تعديل
                                                </a>

                                            </div>
                                        </th>
                                        <th>{{ $order_type->name }}</th>

                                        <td>{{ $order_type->name_ar }}</td>
                                        <td>{{ $order_type->phone_number }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js">
    </script>


    <script>
        $(document).on('click', '.active_ordertype', function(e) {
            e.preventDefault();
            var offer_id = $(this).attr('offer_id');
            $.ajax({
                type: 'PUT',
                url: "{{ route('order_type_active') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': offer_id
                },
                success: function(data) {
                    if (data.status == true) {
                        window.location.reload();
                    }
                },
                error: function(reject) {}
            });
        });
    </script>

@endsection
