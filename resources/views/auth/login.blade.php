@extends('master.index')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

    <div class="container">
    @include('buyer-side.includes.notices')
        <div class="row justify-content-center" style="margin-top: 7rem;">
        
            <div class="col-md-5">
                <div class="card-template">
                    <div class="card t-card">
                        <div class="card-body">
                            <form action="{{ route('guest.loginBuyer') }}" method="POST">
                            @csrf
                            <input type="hidden" name="storeName" value="{{ $storeName }}"/>
                                <div class="form-group">
                                <label for="exampleInputEmail1">EMAIL ADDRESS</label>
                                <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                @if ($errors->has('email'))
                                            <span class="text-danger">
                                                <p>{{ $errors->first('email') }}</p>
                                            </span>
                                        @endif
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">PASSWORD</label>
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                                @if ($errors->has('password'))
                                            <span class="text-danger">
                                                <p>{{ $errors->first('password') }}</p>
                                            </span>
                                        @endif
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </form>
                            <div class="text-center" style="margin-top:1rem">
                                    <span>Don't have account yet?
                                    <a href="{{route('guest.user-register',['storeName' => $storeName])}}" class="text-center">
                                         <b>Click here to sign up</b></span>
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection