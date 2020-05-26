@extends('layout.base')

@section('main')
    <h5>
        {{ $music->name }}
    </h5>

    <p>
        {{ $music->getSize() }} ({{ $music->size }} bytes)
    </p>
    <p class="text-right">
        {{ $music->mime }}
    </p>
    <hr>

    <audio src="{{ route('storage.music', ['name' => $music->sha1]) }}" controls></audio>
    <p class="text-right">
        <a class="btn btn-info" href="{{ route('storage.music', ['name' => $music->sha1]) }}" download>
            Download
        </a>
    </p>
@endsection