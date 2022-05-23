@extends('layouts.app')

@section('content')

<div class="admin-components ">
    <div class="col-md-8">
        <div class="login-card">

            <div class="card-body">
                <form method="POST" action="{{ route('login', app()->getLocale()) }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <a class="btn-link pull-right" href="/admin/create-account">
                            {{ __('Create Account') }}
                        </a>
                        <input id="email" type="email" required name="email" value="{{ old('email') }}"
                            class="form-control  @error('email') is-invalid @enderror" placeholder="Enter Email"
                            autocomplete="email" autofocus />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        @if (Route::has('password.request'))
                        <a class="btn-link forgot pull-right" href="{{ route('password.request', app()->getLocale()) }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password"
                            name="password" required autocomplete="current-password">


                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>

                    <!-- <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label pl-2 pt-1" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                    <div class="form-group mb-0">
                        <div class="">
                            <button type="submit" class=" login-btn default-btn">
                                {{ __('LOGIN') }}
                            </button>

                        </div>
                        <a class="btn-link return pull-right" href="/">
                            {{ __(' <— Return to Patient Education 101') }}
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection
