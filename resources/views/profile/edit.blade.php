@extends('layouts.app', ['title' => __('User Profile')])
@section('profile')
    text-primary
@endsection
@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __(''),
        'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    @if(auth()->user()->image)
                                        <img src="{{auth()->user()->image_path}}" class="rounded-circle">
                                    @else
                                        <img src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg"
                                             class="rounded-circle">
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                    {{--                                    <div>--}}
                                    {{--                                        <span class="heading">22</span>--}}
                                    {{--                                        <span class="description">{{ __('Friends') }}</span>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div>--}}
                                    {{--                                        <span class="heading">10</span>--}}
                                    {{--                                        <span class="description">{{ __('Photos') }}</span>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div>--}}
                                    {{--                                        <span class="heading">89</span>--}}
                                    {{--                                        <span class="description">{{ __('Comments') }}</span>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3>
                                {{ auth()->user()->name }}<span class="font-weight-light">, 27</span>
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>{{Auth::user()->balance}} IQD
                            </div>


                            {{--                            <hr class="my-4" />--}}
                            {{--                            <p>{{ __('Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music.') }}</p>--}}
                            {{--                            <a href="#">{{ __('Show more') }}</a>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0 text-right">{{ __('معلومات المستخدم') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}" autocomplete="off"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label float-right " for="input-name">{{ __('الاسم') }}</label>
                                    <input type="text" name="name" id="input-name"
                                           class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="{{ __('Name') }}"
                                           value="{{ old('name', auth()->user()->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                    <label class="form-control-label float-right " for="city_id">{{ __('المدينه') }}</label>
                                    <select class="form-control" id="city_id" name="city_id">
                                        @foreach($cities as $city)

                                            @if(auth()->user()->city_id == $city->id)  <option value="{{$city->id}}" selected>{{$city->name}}</option>
                                            @else <option value="{{$city->id}}" >{{$city->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                    <label class="form-control-label float-right" for="input-name">{{ __('الصورة') }}</label>
                                    <input type="file" name="image" id="input-name"
                                           class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                           placeholder="{{ __('image') }}" autofocus>

                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
