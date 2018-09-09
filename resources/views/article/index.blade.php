@extends('layouts.app')

@section('content')

<div class="container">

    @if (\Session::has('success'))
        <div class="alert alert-success">
            {!! \Session::get('success') !!}
        </div>
    @endif

    @if (\Session::has('error'))
        <div class="alert alert-danger">
            {!! \Session::get('error') !!}
        </div>
    @endif

	<a class="btn btn-primary" href="{{ route('articles.create') }}">New Article</a>
	<table class="table table-striped">
		<thead>
			<tr>
			<th scope="col">#</th>
			<th scope="col">Title</th>
			<th scope="col">Created By</th>
			<th scope="col">Date Created</th>
			<th scope="col">Status</th>
			<th scope="col">Edit</th>
			<th scope="col">Delete</th>
			</tr>
		</thead>
		@if(!empty($entities))
		<tbody>
			@foreach($entities as $entity)
			<tr>
				<td>{{ $entity->id }}</td>
				<td>{{ $entity->title }}</td>
				<td>{{ $entity->user->name }}</td>
				<td>{{ $entity->created_at->format('d/m/Y') }}</td>
				<td>{{ $entity->status }}</td>
				<td>
					<a class="btn btn-success" href="{{ route('articles.edit', ['article' => $entity->id]) }}">
						edit
					</a>
				</td>
				<td>
					<form method="POST" action="{{ route('articles.destroy', ['article' => $entity->id]) }}">
						{!! method_field('delete') !!}
						{!! csrf_field() !!}
						<button class="btn btn-danger">delete</button>
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
		@endif
	</table>
</div>

@endsection