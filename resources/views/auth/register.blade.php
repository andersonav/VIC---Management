@extends('layouts.painelLogin')

@section('content')
<div class="row">
    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
    <div class="col-lg-7">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
            </div>
            @if(isset($error))
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
            @endif
            <form class="user" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control form-control-user" id="name" placeholder="Name" value="{{ old('name') }}" required name="name">
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password" required>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <input type="password" class="form-control form-control-user" id="password_confirmation" placeholder="Repeat Password" name="password_confirmation">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Register Account
                </button>
                <!-- <a href="login.html" class="btn btn-primary btn-user btn-block">
                    Register Account
                </a> -->
                <hr>
                <a href="index.html" class="btn btn-google btn-user btn-block">
                    <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
            <div class="text-center">
                <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
            </div>
        </div>
    </div>
</div>


@endsection