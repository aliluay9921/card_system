@extends('layouts.app')
@section('users')
    text-primary
@endsection
@section('content')
    @include('layouts.headers.cards')



    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Users</h3>
                            </div>
                            <div class="col-4 text-right">
                                {{--                                <a href="" class="btn btn-sm btn-primary">Add user</a>--}}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr class="text-center">
                                <th scope="col">الاسم</th>
                                <th scope="col">الهاتف</th>
                                <th scope="col">رمز الدخول</th>
                                <th scope="col">الرصيد الحالي</th>
                                <th scope="col">تاريخ التسجيل</th>
                                <th scope="col">تاريخ التفعيل</th>
                                <th scope="col"> المدينة مرتبط مع جدول البطاقات</th>
                                <th scope="col">تفعيل/ الغاء</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr class="text-center">
                                    <td>
                                        {{$user->name}}
                                    </td>
                                    <td>
                                        {{$user->phone}}

                                    </td>
                                    <td>
                                        {{$user->id}}

                                    </td>
                                    <td>
                                        {{$user->balance}}
                                    </td>
                                    <td>
                                        {{$user->created_at}}
                                    </td>
                                    <td>
                                        @if($user->activate_at)
                                            {{$user->activate_at}}
                                        @else
                                            غير فعال@endif
                                    </td>
                                    <td>
                                        {{$user->city->name}}
                                    </td>

                                    <td>
                                        @if($user->activate_at)
                                            <form action="{{route('user.update',['user'=>$user->id])}}" method="post">
                                                @csrf
                                                <input name="_method" type="hidden" value="PUT">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                        الغاء التفعيل
                                                </button>
                                            </form>

                                        @else
                                            <form action="{{route('user.update',['user'=>$user->id])}}" method="post">
                                                @csrf
                                                <input name="_method" type="hidden" value="PUT">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                     التفعيل
                                                </button>
                                            </form>
                                        @endif

                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                   href="{{route('users.edit',[$user->id])}}">Edit</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $users->links() }}

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
