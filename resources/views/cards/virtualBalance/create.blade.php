@extends('layouts.app')
@section('virtualBalance')
    text-primary
@endsection
@section('content')
    @include('users.partials.header',
      [
         'title' => __('') ,
         'class' => 'col-lg-12'
     ]
     )

    <div class="container mt--7" id="app">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header align-items-center ">
                        <a href="{{route('virtualBalance.index')}}" class="btn btn-primary"> جدول الرصيد الافتراضي</a>
                    </div>
                    <div class="card-body ">
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
                        <div class="w-100">
                            <div class="form-group mx-auto">
                                <div class="row">

                                    <div class="col-md-4"></div>

                                    <div class="col-md-4">
                                        <v-select :options="suggestionOptions"
                                                  @search="fetchOptions"
                                                  v-model="phone"></v-select>
                                        @error('phone')
                                        <div class="error text-danger text-right">{{ $errors->first('phone') }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label for="phone" class="text-right">رقم الهاتف </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mx-auto">
                                <div class="row">

                                    <div class="col-md-4"></div>

                                    <div class="col-md-4">
                                        <input type="text" class="form-control" v-model="user_name">
                                        @error('user_name')
                                        <div
                                            class="error text-danger text-right">{{ $errors->first('user_name') }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label for="user_name" class="text-right">اسم المستخدم</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mx-auto">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="before" id="before"
                                               readonly v-model="before">
                                        @error('before')
                                        <div
                                            class="error text-danger text-right">{{ $errors->first('before') }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label for="user_name" class="text-right">الرصيد السابق</label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group mx-auto">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="amount" id="amount"
                                               v-model="amount"
                                        >
                                        @error('amount')
                                        <div
                                            class="error text-danger text-right">{{ $errors->first('amount') }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <label for="user_name" class="text-right">المقدار</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <span class="w-100  d-flex mt-4">
                                <button @click="save()" type="button"
                                        class="btn btn-success m-auto  w-25">اضافه</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/app.js"></script>

    <script>
        const app = new Vue({
            el: '#app',
            data: {
                user_name: '',
                amount: '',
                phone: 0,
                suggestionOptions: [],
                users: [],
                before: 0
            },
            methods: {
                fetchOptions(search, loading) {
                    if (search) {
                        axios.get("{{route('user.search')}}", {
                            params: {
                                q: search
                            }
                        }).then((response) => {
                            this.suggestionOptions = [];

                            this.users = response.data;
                            response.data.forEach(element => {

                                this.suggestionOptions.push(
                                    {
                                        code: element.phone,
                                        label: element.phone,
                                        user_name: element.user_name,
                                        id: element.id,
                                        before: element.balance,
                                    }
                                )
                            });

                        }).catch(function (error) {
                        });
                    }
                },
                save() {
                    axios.post("{{route('virtualBalance.store')}}", {
                        'user_id': this.phone.id,
                        'amount': this.amount,
                    }).then((response) => {
                        window.location.reload();
                    }).catch(error => {
                        localStorage.setItem('user_id', this.phone.id);
                        window.location.reload();
                    });
                },
                getUser() {


                },

            }, watch: {
                phone: function (val) {
                    if (!val || val == '') {
                        this.user_name = '';
                    } else {
                        this.user_name = this.phone.user_name;
                        this.before = this.phone.before;
                    }

                }
            },
            created() {
                console.log(localStorage.getItem('user_id'));
                if (localStorage.getItem('user_id')) {
                    var url = "{{route('users.show')}}";
                    axios.get(url + "/" + localStorage.getItem('user_id'))
                        .then((response) => {
                            this.phone = {
                                code: response.data.phone,
                                label: response.data.phone,
                                user_name: response.data.user_name,
                                id: response.data.id,
                                before: response.data.balance,
                            };
                            localStorage.setItem('user_id', '');

                        }).catch(function (error) {
                    });

                }
            },
        });

    </script>
@endsection


@section('js')

@endsection
