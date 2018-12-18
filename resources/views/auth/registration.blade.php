@extends('master.index')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

    <div class="container">
        <div class="row justify-content-center" style="margin-top: 7rem;">
            <div class="col-md-5">
                <div class="card-template">
                    <div class="card t-card">
                        <div class="card-body">
                            <form action="{{ route('guest.postBuyerRegister') }}" method="POST">
                            @csrf
                                <input type="hidden" name="store_name" value="{{ $data->store_name }}">
                                <div class="form-group">
                                <label for="exampleInputEmail1">Firstname</label>
                                <input type="text" name="firstname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                @if ($errors->has('firstname'))
                                            <span class="text-danger">
                                                <p>{{ $errors->first('firstname') }}</p>
                                            </span>
                                        @endif
                                </div>
                                 <div class="form-group">
                                <label for="exampleInputEmail1">Lastname</label>
                                <input type="text" name="lastname"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                @if ($errors->has('lastname'))
                                            <span class="text-danger">
                                                <p>{{ $errors->first('lastname') }}</p>
                                            </span>
                                        @endif
                                </div>
                                 <div class="form-group">
                                <label for="exampleInputEmail1">EMAIL ADDRESS</label>
                                <input type="email" name="email"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                                @if ($errors->has('email'))
                                            <span class="text-danger">
                                                <p>{{ $errors->first('email') }}</p>
                                            </span>
                                        @endif
                                </div>
                                <div class="form-row">
                                        <div class="col">
                                          <input type="password" name="password" class="form-control" placeholder="Password">
                                          @if ($errors->has('password'))
                                            <span class="text-danger">
                                                <p>{{ $errors->first('password') }}</p>
                                            </span>
                                        @endif
                                        </div>
                                        <div class="col">
                                          <input type="password" name="password_confirmation"  class="form-control" placeholder="Confirm Password">
                                          @if ($errors->has('confirm'))
                                            <span class="text-danger">
                                                <p>{{ $errors->first('confirm') }}</p>
                                            </span>
                                        @endif
                                        </div>
                                      </div>

                                        {!! NoCaptcha::display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">
                                        <p>{{ $errors->first('g-recaptcha-response') }}</p>
                                    </span>
                                @endif

                                      <div class="text-center" style="margin-top:1rem">
                                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                                    <span>Don't have account yet?
                                    <a href="#" class="text-center">
                                         <b>Click here to sign up</b></span>
                                    </a>
                                </div>
                            </form>
                           

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endpush