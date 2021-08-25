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
                        <form action="{{route('company.update',['company'=>$company->id])}}" method="post"
                              enctype="multipart/form-data">
                            @method('PUT')

                            @csrf
                            <div class="form-group">
                                <label for="name" class="w-100 text-right">الاسم </label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{$company->name}}">
                                @error('name')
                                <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="active" class="w-100 text-right">الحالة</label>
                                <select class="form-control" id="active" name="active">
                                    <option value="1" @if($company->active)selected @endif>فعال</option>
                                    <option value="0" @if(!$company->active)selected @endif>غير فعال</option>
                                </select>
                                @error('active')
                                <div class="error text-danger text-right">{{ $errors->first('active') }}</div>
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
                                <input type="submit" class="btn btn-success m-auto  w-25" value="تعديل">
                            </span>
                        </form>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <img src="{{$company->avatar_image}}" alt="Girl in a jacket">

                        </div>
                        <div class="col-md-6 col-6">
                            <img src="{{$company->cover_image}}" alt="Girl in a jacket">

                        </div>

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
