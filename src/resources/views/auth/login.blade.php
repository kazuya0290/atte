@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="title_header">{{ __('ログイン') }}</div>
                <div class="title_body">
                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row_mb-3">
                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="メールアドレス" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row_mb-3">
                            <div class="col-md-6">
                                <input id="password" type="password" placeholder= "パスワード" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button id="login" type="submit" class="btn btn-primary" name="btn-login">
                                    {{ __('ログイン') }}
                                </button>
                                <label class="register-label">アカウントをお持ちでない方はこちらから</label>
                                <label>↓↓↓</label>
      <a class="footer__link" href="/register">会員登録</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
