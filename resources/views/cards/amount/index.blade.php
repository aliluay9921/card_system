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
    <div class="container mt--7">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between ">
                        <a href="{{route('amount.create')}}" class="btn btn-primary">اضافه</a>
                        <b class="h2"> جدول قيم البطاقات</b>
                    </div>
                    <div class="card-body ">
                        <table class="table">
                            <thead>
                            <tr class="text-center">

                                <th>#</th>
                                <th>اضافته في</th>

                                <th>الحاله</th>

                                <th>القيمة</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach( $amounts as $amount)
                                <tr class="text-center">
                                    <th>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">
                                            @if($amount->active)
                                                <button type="button" class="btn btn-danger" disabled>تعطيل</button>
                                            @else
                                                <button type="button" class="btn btn-success" disabled> تشغيل</button>
                                            @endif
                                            <a href="{{route('amount.edit',$amount->id)}}" type="button" class="btn btn-info">
                                                تعديل
                                            </a>
                                        </div>
                                    </th>
                                    <th>{{$amount->created_at}}</th>

                                    <td>@if($amount->active)
                                            شغال
                                        @else
                                            غير شغال
                                        @endif
                                    </td>
                                    <td>{{number_format($amount->value) }}</td>
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


