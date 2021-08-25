@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--6">
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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-100">
                        <div class="float-left">
                            <a href="{{route('users.index')}}" class="btn btn-primary "> المستخدمين </a>
                            {{----}}
                            {{--                            <button type="button" class="btn btn-primary  mx-3" data-toggle="modal"--}}
                            {{--                                    data-target="#addBalanceModal">--}}
                            {{--                                اضافه رصيد--}}
                            {{--                            </button>--}}
                        </div>
                        <div class="float-right">
                            <p class="h1 text-right">الاسم : {{$user->name}}</p>
                            <br>
                            <br>
                            <p class="h1 text-right">الرصيد : {{$user->balance}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center my-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-100">
                        <h1 class="w-100 justify-content-end d-flex">تغير كلمه السر</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{route('users.change.password',['user'=>$user->id])}}" method="post" class="row">

                            @csrf
                            @method('put')
                            <div class="d-flex w-100 px-2">
                                <input type="submit" class="form-control btn btn-primary col-3" value="حفظ">
                                <input type="password" class="form-control col-3" name="password_confirmation" placeholder="تاكيد كلمه المرور">
                                <input type="password" class="form-control col-3" name="password" placeholder="كلمه المرور">
                                <input type="text" class="form-control col-3" name="phone" placeholder="رقم هاتف الشخص" value="{{old('phone')}}">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="row justify-content-center my-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header w-100">
                        <h1 class="w-100">User Roles</h1>
                    </div>
                    <div class="card-body">
                        @foreach($roles as $key=>$role)
                            <div class="table-responsive my-3">
                                <div class="w-100">
                                    <h2 class="text-primary text-capitalize w-100">
                                        #{{$key+1}} {{$role->name}}
                                        <label class="custom-toggle float-right">
                                            <input type="checkbox"
                                                   @if(in_array ("$role->name" ,$user_role))
                                                   checked
                                                   @endif
                                                   onchange='window.location="{{route('user.userRoles',[$user->id,$role->id])}}"'>
                                            <span class="custom-toggle-slider rounded-circle"></span>
                                        </label>
                                    </h2>
                                </div>
                                @if(count($role->permissions))
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Role Permissions</th>
                                            <th scope="col">created at</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($role->permissions as $permission)
                                            <tr class="text-capitalize">
                                                <td>{{$permission->name}}</td>
                                                <td>{{$permission->created_at}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{--    <div class="modal fade" id="addBalanceModal" tabindex="-1" role="dialog"--}}
    {{--         aria-labelledby="addBalanceModalTitle" aria-hidden="true">--}}
    {{--        <div class="modal-dialog modal-dialog-centered" role="document">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title" id="addBalanceModalTitle">اضافه رصيد</h5>--}}
    {{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                        <span aria-hidden="true">&times;</span>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body">--}}
    {{--                    <div class="w-100 row pr-2 ml-0">--}}
    {{--                        <p class="px-0 mx-0 text-right w-100">--}}
    {{--                            الرصيد السابق--}}
    {{--                            <b class="font-weight-bold">--}}
    {{--                                {{$user->balance}}</b>--}}
    {{--                            دينار عراقي--}}
    {{--                        </p>--}}
    {{--                    </div>--}}

    {{--                    <div class="form-group row">--}}
    {{--                        <label for="balance" class="col-sm-1 col-form-label">IDQ</label>--}}
    {{--                        <div class="col-sm-8">--}}
    {{--                            <input class="form-control" type="number" min="0" id="balance"--}}
    {{--                                   placeholder="مقدار الرصيد المضاف بلدينار العراقي"--}}
    {{--                                   onkeyup="countNewBalance('{{$user->balance}}',this.value) ">--}}
    {{--                        </div>--}}

    {{--                        <label for="balance" class="col-sm-3 col-form-label">مقدار الاضافه</label>--}}
    {{--                    </div>--}}

    {{--                    <div class="w-100 row pr-2 ml-0">--}}
    {{--                        <p class="px-0 mx-0 text-right w-100">--}}
    {{--                            الرصيد الجديد--}}
    {{--                            <b class="font-weight-bold text-danger" id="newBalance">--}}
    {{--                                {{$user->balance}}--}}
    {{--                            </b>--}}
    {{--                            دينار عراقي--}}
    {{--                        </p>--}}
    {{--                    </div>--}}

    {{--                </div>--}}
    {{--                <div class="modal-footer">--}}
    {{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>--}}
    {{--                    <button type="button" class="btn btn-primary" onclick="StoreNewBalance()">اضافه</button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>--}}

    {{--    <script>--}}
    {{--        function countNewBalance(oldBalance, value) {--}}
    {{--            var x = parseFloat(oldBalance) + parseFloat(value);--}}
    {{--            document.getElementById('newBalance').innerText = isNaN(x) ? oldBalance : x;--}}
    {{--        }--}}

    {{--        function StoreNewBalance() {--}}
    {{--            var value = document.getElementById('balance').value;--}}
    {{--            axios.put("{{route('user.balance.update',['user'=>$user->id])}}", {--}}
    {{--                balance: value,--}}
    {{--            }).then(function (response) {--}}
    {{--                window.location.reload();--}}
    {{--            }).catch(function (error) {--}}
    {{--                console.log(error);--}}
    {{--            });--}}
    {{--        }--}}

    {{--    </script>--}}
@endsection



