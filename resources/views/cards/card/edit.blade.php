{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header align-items-center ">--}}
{{--                        <a href="{{route('city.index')}}" class="btn btn-primary"> جدول المدن</a>--}}
{{--                    </div>--}}
{{--                    <div class="card-body ">--}}
{{--                        <form action="{{route('city.update',['city'=>$city->id])}}" method="post" enctype="multipart/form-data">--}}
{{--                            @method('PUT')--}}

{{--                            @csrf--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="name" class="w-100 text-right">الاسم </label>--}}
{{--                                <input type="text" class="form-control" id="name" name="name" value="{{$city->name}}">--}}
{{--                                @error('name')--}}
{{--                                <div class="error text-danger text-right">{{ $message }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="active" class="w-100 text-right">الحالة</label>--}}
{{--                                <select class="form-control" id="active" name="active">--}}
{{--                                    <option value="1" @if($city->active)selected @endif>فعال</option>--}}
{{--                                    <option value="0" @if(!$city->active)selected @endif>غير فعال</option>--}}
{{--                                </select>--}}
{{--                                @error('active')--}}
{{--                                <div class="error text-danger text-right">{{ $errors->first('active') }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}


{{--                            <span class="w-100  d-flex mt-4">--}}
{{--                                <input type="submit" class="btn btn-success m-auto  w-25" value="تعديل">--}}
{{--                            </span>--}}
{{--                        </form>--}}

{{--                    </div>--}}


{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}


{{--    </div>--}}
{{--@endsection--}}


{{--@section('js')--}}
{{--    <script>--}}


{{--    </script>--}}
{{--@endsection--}}
