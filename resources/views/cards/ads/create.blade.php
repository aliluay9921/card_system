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
              href="https://cdn.jsdelivr.net/npm/tail.select@0.5.15/css/default/tail.select-light.min.css"/>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header align-items-center ">
                        <a href="{{route('ads.index')}}" class="btn btn-primary"> الاعلانات </a>
                    </div>
                    <div class="card-body ">

                        <form action="{{route('ads.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title" class="w-100 text-right">العنوان </label>
                                <input type="text" class="form-control" id="title" name="title">

                                @error('title')
                                <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="url" class="w-100 text-right">رابط الاعلان </label>
                                <input type="text" class="form-control" id="url" name="url">

                                @error('url')
                                <div class="error text-danger text-right">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="public" class="w-100 text-right">عام </label>
                                <select class="form-control" id="public" name="public" onchange="change(this);">
                                    <option value="1">عام</option>
                                    <option value="0"> موجه</option>
                                </select>
                                @error('public')
                                <div class="error text-danger text-right">{{ $errors->first('public') }}</div>
                                @enderror
                            </div>


                            <div class="form-group" id="userSelection" style="display: none">
                                <label for="users" class="w-100 text-right">المستخدمين </label>
                                <select class="form-control" id="users" name="users[]" multiple>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach

                                </select>
                                @error('users')
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

                            <div class="custom-file my-1">
                                <input type="file" class="custom-file-input" name="image" id="image">
                                <label class="custom-file-label" for="image">اختر صوره</label>
                                @error('image')
                                <div class="error text-danger text-right">{{ $errors->first('image') }}</div>
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



{{--<select class="select" multiple>--}}
{{--    <option>[...]</option>--}}
{{--    <option>[...]</option>--}}
{{--    <option>[...]</option>--}}
{{--</select>--}}
