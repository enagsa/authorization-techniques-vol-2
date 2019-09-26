@extends('layouts.layout')

@section('title', 'Listado de Posts')

@section('content')
	<h1>Listado de Posts</h1>

	@can('create', App\Models\Post::class)
		<a id="crear-usuario" class="volver" href="{{-- route('users.create') --}}">Nuevo post <i class="fa fa-plus"></i></a>
	@endcan

	@if($posts->isEmpty())
		<p>No hay posts registrados</p>
	@else
		<section class="table">
			<div class="table-line title">
				<div class="table-cell">#</div>
				<div class="table-cell">Título</div>
				<div class="table-cell">Autor</div>
				<div class="table-cell">Acciones</div>
			</div>
			@foreach($posts as $post)
				<div class="table-line">
					<div class="table-cell">{{ $post->id }}</div>
					<div class="table-cell">{{ $post->title }}</div>
					<div class="table-cell">{{ $post->author->name }}</div>
					<div class="table-cell">
						<a class="boton view" href="{{-- route('users.show', $user) --}}"><i class="fa fa-eye"></i></a>

						@can('update', $post)
							<a class="boton edit" href="{{ route('posts.edit', $post) }}"><i class="fa fa-pencil"></i></a>
						@elsecan('report', $post)
							<a class="boton edit" href="#"><i class="fa fa-warning"></i></a>
						@endcan

						@can('delete', $post)
							<form action="{{-- route('users.destroy', $user) --}}" method="POST">
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
								<button class="boton delete" type="submit"><i class="fa fa-trash"></i></button>
							</form>
						@endcan
					</div>
				</div>
			@endforeach
		</section>
		{{ $posts->links() }}
	@endif
@endsection