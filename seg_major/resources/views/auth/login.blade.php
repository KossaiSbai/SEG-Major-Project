@extends('layouts.app.app1')
@section('supercontent')



    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="loginContainer">



            <label for="username"><b>{{ __('Username') }}</b></label>

            <input type="text" placeholder="Enter username"   class="{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}"  required autofocus >

            @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
            @endif


            <label for="password"><b>{{ __('Password') }}</b></label>

            <input placeholder="Enter password" id="password" type="password"  class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
            @endif



            <button type="submit" class="loginButton" >Login</button>

            <div class = "registerCont">
          <span class="register"> <a class="ml-auto" href={{route('register')}}>Register User</a>
          </span>
            </div>
        </div>

    </form>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
@include('flash-messages')

