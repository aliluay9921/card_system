@extends('layouts.app')

@section('ads')
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
        <link type="text/css" rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/tail.select@0.5.15/css/default/tail.select-light.min.css" />

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header align-items-center ">
                        <a href="{{ route('order_type.index') }}" class="btn btn-primary"> نوع الحوالات </a>
                    </div>
                    <div class="card-body ">

                        <form action="{{ route('order_type.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="title" class="w-100 text-right">الاسم </label>
                                <input type="text" class="form-control" id="name" name="name">

                                @error('name')
                                    <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="url" class="w-100 text-right">الاسم عربي </label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar">

                                @error('name_ar')
                                    <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="public" class="w-100 text-right">رقم الهاتف </label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number">
                                @error('phone_number')
                                    <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="active" class="w-100 text-right">الحالة</label>
                                <select class="form-control" id="active" name="active">
                                    <option value="1">فعال</option>
                                    <option value="0">غير فعال</option>
                                </select>
                                @error('active')
                                    <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>
                            <span class="w-100  d-flex mt-4">
                                <input type="submit" class="btn btn-success m-auto  w-25" value="اضافه">
                            </span>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tail.select@latest"></script>
    <script>
        function change(sel) {

            if (sel.value == 0) {

                $('#userSelection').show();

                tail.select("#users", {

                    height: 350,
                    locale: "ar",
                    multiple: true,
                    multiSelectAll: true,
                    search: true,
                    searchConfig: ["text"],
                    searchFocus: true,
                    searchMarked: true,
                    width: '100%',


                });
            }

        }
    </script>
@endsection



{{-- <select class="select" multiple> --}}
{{-- <option>[...]</option> --}}
{{-- <option>[...]</option> --}}
{{-- <option>[...]</option> --}}
{{-- </select> --}}
