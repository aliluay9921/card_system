@extends('layouts.app')

@section('amount')
    text-primary
@endsection
@section('content')
    @include('users.partials.header',
     [
        'title' => __('') ,
        'class' => 'col-lg-12'
    ]
    )

    <div class="container mt--7">        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header align-items-center ">
                        <a href="{{route('amount.index')}}" class="btn btn-primary"> جدول القيم</a>
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
                        <form action="{{route('amount.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="w-100 text-right">الاسم </label>
                                <input type="text" class="form-control" id="name" name="value">

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



