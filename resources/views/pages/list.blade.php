@extends('layout.base')

@section('main')
    <ul class="list-group">
        @foreach($list as $music)
            <li class="list-group-item">
                <a href="{{ route('storage.music', ['name' => $music->sha1]) }}">
                    {{ $music->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection