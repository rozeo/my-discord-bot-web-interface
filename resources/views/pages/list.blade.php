@extends('layout.base')

@section('main')
    <ul class="list-group">
        @foreach($list as $music)
            <li class="list-group-item">
                <a href="{{ route('storage.music', ['name' => $music->sha1]) }}">
                    {{ $music->name }}
                </a>

                <div class="text-right">
                    uploaded by: {{ $music->uid }}
                </div>

                <div class="text-right">
                    {{ $music->size }} bytes
                </div>
            </li>
        @endforeach
    </ul>
@endsection