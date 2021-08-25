@extends('layouts.app')
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
    <div class="container mt--7">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header align-items-center ">
                        <a href="{{route('card.index')}}" class="btn btn-primary"> جدول البطائق</a>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card-body ">
                        <form action="{{route('card.store')}}" method="post" enctype="multipart/form-data">
                            @csrf


                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="city" class="w-100 text-right">المدينه </label>
                                    <select class="form-control" id="city" name="city_id">
                                        @foreach($cities as $city)
                                            <option
                                                value="{{$city->id}}"
                                                {{ (old('city_id') == $city->id ? "selected":"") }}>
                                                {{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                    <div class="error text-danger text-right">{{ $errors->first('city') }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="amount" class="w-100 text-right">الفئة </label>
                                    <select class="form-control" id="amount" name="amount_id">
                                        @foreach($amounts as $amount)
                                            <option value="{{$amount->id}}"
                                                {{ (old('amount_id') == $amount->id ? "selected":"") }}>
                                                {{$amount->value}}</option>
                                        @endforeach
                                    </select>
                                    @error('amount')
                                    <div class="error text-danger text-right">{{ $errors->first('amount') }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="amount" class="w-100 text-right">الشركه </label>
                                    <select class="form-control" id="company" name="company_id">
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}"
                                                {{ (old('company_id') == $company->id ? "selected":"") }}>
                                                {{$company->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('company')
                                    <div class="error text-danger text-right">{{ $errors->first('company') }}</div>
                                    @enderror
                                </div>


                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="sale_price" class="w-100 text-right">سعر البيع</label>
                                    <input class="form-control" id="sale_price" type="number"
                                           placeholder="سعر البيع بلدينار العراقي"
                                           value="{{old('sale_price')}}"
                                           name="sale_price">
                                    @error('sale_price')
                                    <div class="error text-danger text-right">{{ $errors->first('sale_price') }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="puy_price" class="w-100 text-right">سعر الشراء</label>
                                    <input class="form-control" id="puy_price" type="number"
                                           placeholder="سعر الشراء بلدينار العراقي"
                                           value="{{old('puy_price')}}"
                                           name="puy_price">
                                    @error('puy_price')
                                    <div class="error text-danger text-right">{{ $errors->first('sale_price') }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="owner" class="w-100 text-right"> اسم المالك</label>
                                    <input class="form-control" id="owner" type="text"
                                           placeholder="اسم المالك"
                                           value="{{old('owner')}}"
                                           name="owner">
                                    @error('owner')
                                    <div class="error text-danger text-right">{{ $errors->first('owner') }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="custom-file my-1">
                                <input type="file" class="custom-file-input" name="file" id="file">
                                <label class="custom-file-label" for="file"> اختر الملف</label>
                                @error('file')
                                <div class="error text-danger text-right">{{ $errors->first('file') }}</div>
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
