@extends('layouts.layout')

@section('title', $post->title)

@section('content')
	<h1>{{ $post->title }}</h1>
    <p>{{ $post->teaser }}</p>
    <hr/>
    @can('see-content')
        <section class="table">
            {{ $post->content }}
        </section>
    @else
        <p>
            No tienes permisos para ver el contenido
        </p>
    @endcan
@endsection
