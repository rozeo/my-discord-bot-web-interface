@extends('layout.base')

@section('main')
    <h5>
        ログインが必要です。
    </h5>

    <a href="{{ $redirectUri }}">
        <button class="btn btn-info">ログイン</button>
    </a>
@endsection