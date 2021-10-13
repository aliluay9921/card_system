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
                    <div class="card-header d-flex justify-content-between ">
                        <a href="{{ route('company.create') }}" class="btn btn-primary">اضافه</a>

                        <b class="h2"> جدول الشركات</b>
                    </div>
                    <div class="card-body ">
                        <table class="table">
                            <thead>
                                <tr class="text-center">

                                    <th>#</th>
                                    <th>اضافته في</th>

                                    <th>الحاله</th>

                                    <th>رقم الهاتف</th>
                                    <th>الاسم</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                    <tr class="text-center">
                                        <th>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="">
                                                @if ($company->active)
                                                    <button type="button" class="btn btn-danger" disabled>تعطيل</button>
                                                @else
                                                    <button type="button" class="btn btn-success" disabled> تشغيل</button>
                                                @endif
                                                <a href="{{ route('company.edit', $company->id) }}" type="button"
                                                    class="btn btn-info">
                                                    تعديل
                                                </a>
  <a href="{{ route('company.delete', [$company->id]) }}" type="button"
                                                    class="btn btn-danger">
                                                    حذف
                                                </a>
                                            </div>
                                        </th>
                                        <th>{{ $company->created_at }}</th>

                                        <td>
                                            @if ($company->active)
                                                شغال
                                            @else
                                                غير شغال
                                            @endif
                                        </td>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->name }}</td>
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
