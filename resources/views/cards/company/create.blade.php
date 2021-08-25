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
                    <div class="card-header align-items-center ">
                        <a href="{{route('company.index')}}" class="btn btn-primary"> جدول الشركات</a>
                    </div>
                    <div class="card-body ">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="{{route('company.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="w-100 text-right">الاسم </label>
                                <input type="text" class="form-control" id="name" name="name">

                                @error('name')
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
                                <div class="error text-danger text-right">{{ $errors->first('active') }}</div>
                                @enderror
                            </div>
                            <div class="form-group">

                                <label for="example-color-input" class="form-control-label w-100 text-right">لون</label>
                                <input name="color" class="form-control" type="color" value="#5e72e4" id="example-color-input">

                                @error('color')
                                <div class="error text-danger text-right">{{ $errors->first('color') }}</div>
                                @enderror
                            </div>
                            <label for="companyAvatar" class="w-100 text-right">صوره مصغره</label>

                            <div class="custom-file my-1">

                                <input type="file" class="custom-file-input" name="avatar" id="avatar">
                                <label class="custom-file-label" for="avatar">اختر صوره</label>
                                @error('avatar')
                                <div class="error text-danger text-right">{{ $errors->first('avatar') }}</div>
                                @enderror
                            </div>
                            <label for="companyCover" class="w-100 text-right">صوره الغلاف</label>

                            <div class="custom-file my-1">

                                <input type="file" class="custom-file-input" name="cover" id="cover">
                                <label class="custom-file-label" for="cover"> اختر صوره</label>
                                @error('cover')
                                <div class="error text-danger text-right">{{ $errors->first('cover') }}</div>
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
@endsection


@section('js')
    <script>


    </script>
@endsection
