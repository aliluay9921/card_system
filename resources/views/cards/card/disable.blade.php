@extends('layouts.app', ['title' => __('Cards')])
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

    <div class="container-fluid mt--7" id="app">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header align-items-center ">
                        <a href="{{route('card.index')}}" class="btn btn-primary"> جدول البطاقات</a>
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
                        <div class="input-group mb-3 row">
                            <input type="text" class="form-control" v-model="search_word"
                                   placeholder="رقم الوجبة او رقم البطاقة تابعه لها"
                                   @keyup="search()">
                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" @click="search()">بحث</button>
                            </div>
                        </div>
                        <div class="row table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center ">نوع البطاقة</th>
                                    <th class="text-center ">الرمز التسلسلي</th>
                                    <th class="text-center ">المدينه</th>
                                    <th class="text-center ">سعر الشراء</th>
                                    <th class="text-center ">سعر البيع</th>
                                    <th class="text-center ">القيمه</th>
                                    <th class="text-center ">الحاله</th>
                                    <th class="text-center ">تاريخ الادخال</th>
                                    <th class="text-center ">رقم الوجبة</th>
                                    <th class="text-center ">اضافه بواسطه</th>
                                    <th class="text-center ">المالك</th>
                                    <th class="text-center ">#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="card in card_collections">
                                    <th>@{{ card.company.name }}</th>
                                    <td>@{{ card.key }}</td>
                                    <td>@{{ card.city.name }}</td>
                                    <td>@{{ card.puy_price }}</td>
                                    <td>@{{ card.sale_price }}</td>
                                    <td>@{{ card.amount.value }}</td>
                                    <td>@{{ card.used? 'مباع' : 'جديد' }}</td>
                                    <td>@{{ card.created_at }}</td>
                                    <td>@{{ card.collection_id }}</td>
                                    <td>@{{ card.user.name }}</td>
                                    <td>@{{ card.owner }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="">
                                            <button type="button" class="btn btn-danger"
                                                    @click="disable(card.collection_id)">
                                                @{{ card.disable ? 'تفعيل' : 'تعطيل' }}
                                            </button>
                                            <button type="button" class="btn btn-warning"
                                                    @click="card_info=card;collection_id=card.collection_id"
                                                    data-toggle="modal" data-target="#exampleModalCenter">
                                                تعديل
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">تغير الفئه</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row my-3">
                            <div class="col-md-9"><input disabled="disabled" type="text" class="form-control" v-model="collection_id"></div>
                            <div class="col-md-3 mt-2"><label>: رقم الوجبة</label></div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-9">
                                <select class="form-control" v-model="card_info.amount.id" v-if="card_info">
                                    <option :value="amount.id" v-for="amount in amounts">@{{ amount.value }}</option>
                                </select>
                            </div>
                            <div class="col-md-3 mt-2"><label>: الفئه </label></div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-9"><input type="text" class="form-control" v-model="card_info.puy_price"></div>
                            <div class="col-md-3 mt-2"><label>: سعر البيع </label></div>
                        </div>
                        <div class="row my-3">
                            <div class="col-md-9"><input type="text" class="form-control" v-model="card_info.sale_price"></div>
                            <div class="col-md-3 mt-2"><label>: سعر الشراء </label></div>
                        </div> <div class="row my-3">
                            <div class="col-md-9"><input type="text" class="form-control" v-model="card_info.owner"></div>
                            <div class="col-md-3 mt-2"><label>:اسم المالك </label></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="update()">Save</button>
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
                card_collections: [],
                amounts: [],
                search_word: '',
                card_info: '',
                newAmount: '',
                collection_id: ''
            },
            methods: {
                search() {
                    axios.get("{{route('card.search')}}?q=" + this.search_word)
                        .then(response => (
                            this.card_collections = response.data))
                        .catch(function (error) {
                        });

                },
                disable(collection_id) {
                    axios.post("{{route('card.disable')}}", {
                        'collection_id': collection_id,
                    }).then((response) => {
                        window.location.reload();
                    }).catch(error => {
                        window.location.reload();
                    });
                },
                update() {
                    axios.post("{{route('card.amount')}}", {
                        'collection_id': this.collection_id,
                        'amount': this.card_info.amount.id,
                        'puy_price': this.card_info.puy_price,
                        'sale_price': this.card_info.sale_price,
                        'owner': this.card_info.owner,
                    }).then((response) => {
                        window.location.reload();
                    }).catch(error => {
                        window.location.reload();
                    });
                },
            }, mounted() {
                axios.get("/api/v1/amounts").then((response) => {
                    this.amounts = response.data.amounts;
                }).catch(error => {

                });
            }
        });

    </script>
@endsection


@section('js')
    <script>


    </script>
@endsection
