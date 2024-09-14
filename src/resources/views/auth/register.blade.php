@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="title_header">{{ __('会員登録') }}</div>

                <div class="card-body">
                    <form id="register_form" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row_mb-3">
                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="名前" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                <span id="name-error" class="invalid-feedback" role="alert"></span>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row_mb-3">
                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="メールアドレス" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                                <span id="email-error" class="invalid-feedback" role="alert"></span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row_mb-3">
                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="パスワード" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                <span id="password-error" class="invalid-feedback" role="alert"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row_mb-3">
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" placeholder="パスワード確認用" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row_mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('会員登録') }}
                                </button>
                                <label class="login-label">アカウントをお持ちの方はこちらから</label>
                                <label>↓↓↓</label>
                                <a class="footer__link" href="/login">ログイン</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
