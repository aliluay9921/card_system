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
            href="https://cdn.jsdelivr.net/npm/tail.select@0.5.15/css/bootstrap4/tail.select-default.min.css" />

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="margin-left: 975px">
                        <a href="{{ route('card_api.show') }}" class="btn btn-primary">البطاقات </a>
                    </div>
                    <div class="card-body ">

                        <form action="{{ route('card.update', ['id' => $card->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @method('put')

                            @csrf
                            <div class="form-group">
                                <label for="title" class="w-100 text-right">سعر البيع </label>
                                <input type="text" class="form-control" id="sale_card" name="sale_card"
                                    value="{{ $card->sale_card }}">

                                @error('title')
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
                                <label for="image" class="w-100 text-right">الصورة</label>
                                <input type="file" class="form-control" name="image">

                                @error('image')
                                    <div class="error text-danger text-right">{{ $errors->first('image') }}</div>
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
    <script src="https://cdn.jsdelivr.net/npm/tail.select@0.5.15/js/tail.select.min.js"></script>
@endsection
