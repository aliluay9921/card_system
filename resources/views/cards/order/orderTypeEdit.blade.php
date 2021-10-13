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
                        <a href="{{ route('order_type.index') }}" class="btn btn-primary"> جدول انواع الحوالات</a>
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
                        <form method="post" action="{{ route('order_type_update') }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $orderType->id }}">
                            <div class="form-group">
                                <label for="name" class="w-100 text-right">الاسم </label>
                                <input type="text" class="form-control" name="name" value="{{ $orderType->name }}">
                                @error('name')
                                    <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name" class="w-100 text-right">الاسم عربي </label>
                                <input type="text" class="form-control" name="name_ar"
                                    value="{{ $orderType->name_ar }}">
                                @error('name_ar')
                                    <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name" class="w-100 text-right">رقم الهاتف </label>
                                <input type="text" class="form-control" name="phone_number"
                                    value="{{ $orderType->phone_number }}">
                                @error('phone_number')
                                    <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>

                            <span class="w-100  d-flex mt-4">
                                <input type="submit" class="btn btn-success m-auto  w-25" value="تعديل">
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
