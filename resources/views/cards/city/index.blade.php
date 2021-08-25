@extends('layouts.app')
@section('city')
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
                    <div class="card-header d-flex justify-content-between ">
                        <a href="{{route('city.create')}}" class="btn btn-primary">اضافه</a>

                        <b class="h2"> جدول المدن</b>
                    </div>
                    <div class="card-body ">
                        <table class="table">
                            <thead>
                            <tr class="text-center">

                                <th>#</th>
                                <th>اضافته في</th>

                                <th>الحاله</th>

                                <th>الاسم</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach( $cities as $city)
                                <tr class="text-center">
                                    <th>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">
                                            @if($city->active)
                                                <button type="button" class="btn btn-danger" disabled>تعطيل</button>
                                            @else
                                                <button type="button" class="btn btn-success" disabled> تشغيل</button>
                                            @endif
                                            <a href="{{route('city.edit',$city->id)}}" type="button" class="btn btn-info">
                                                تعديل
                                            </a>
                                        </div>
                                    </th>
                                    <th>{{$city->created_at}}</th>

                                    <td>@if($city->active)
                                            شغال
                                        @else
                                            غير شغال
                                        @endif
                                    </td>
                                    <td>{{$city->name}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
