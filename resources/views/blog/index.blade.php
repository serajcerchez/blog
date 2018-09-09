@extends('layouts.app')

@section('content')

<div class="container">
	<h1>Blog</h1>

	@if(!$entities->isEmpty())
	<div class="row">
	@foreach($entities as $entity)
		<div class="col-sm-6">
			<div class="jumbotron">
				<h2>{{ $entity->title }}</h2>
				<p>Date: {{ $entity->created_at->format('d/m/Y') }}</p>
				<p>Author: {{ $entity->user->name }}</p>
				<p>{{ $entity->description }}</p>
				<p><a class="btn btn-primary btn-lg" href="{{ route('blog.article', ['article' => $entity->id]) }}" role="button">Read more</a></p>
			</div>
		</div>
	@endforeach
	</div>
	@endif
</div>

@endsection