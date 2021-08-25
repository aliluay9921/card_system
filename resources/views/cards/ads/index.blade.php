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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between ">
                        <a href="{{route('ads.create')}}" class="btn btn-primary">اضافه</a>
                        <b class="h2"> الاعلانات </b>
                    </div>
                    <div class="card-body ">
                        <table class="table">
                            <thead>
                            <tr class="text-center">

                                <th>#</th>
                                <th>اضافته في</th>
                                <th> عام</th>
                                <th>الحاله</th>
                                <th>الرابط</th>
                                <th>العنوان</th>

                            </tr>

                            </thead>
                            <tbody>
                            @foreach( $ads as $ad)
                                <tr class="text-center">
                                    <th>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">

                                            <a href="{{route('ads.edit',$ad->id)}}" type="button" class="btn btn-info">
                                                تعديل
                                            </a>
                                        </div>
                                    </th>
                                    <th>{{$ad->created_at}}</th>

                                    <td>@if($ad->public)
                                            عام
                                        @else
                                            موجه
                                        @endif
                                    </td>
                                    <td>@if($ad->active)
                                            فعال
                                        @else
                                            غير فعال
                                        @endif
                                    </td>
                                    <td><a href="{{$ad->url}}">اضغط هنا</a></td>
                                    <td>{{$ad->title}}</td>
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


