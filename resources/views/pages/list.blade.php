@extends('layout.base')

@section('main')
    <ul class="list-group">
        @foreach($list as $music)
            <li class="list-group-item">
                <a href="{{ route('music.detail', ['name' => $music->sha1]) }}">
                    {{ $music->name }}
                </a>

                <div class="row">
                    <div class="col-md-6">
                        <audio src="{{ route('storage.music', ['name' => $music->sha1]) }}" controls preload="none"></audio>
                    </div>
                    <div class="col-md-6 text-right">
                        uploaded by: {{ $music->uid }}<br>
                        {{ $music->getSize() }}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endsection