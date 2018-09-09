@extends('layouts.app')

@section('content')

<div class="container">
	<div class="article-container">
		<h1>{{ $entity->title }}</h1>
		<p>Date: {{ $entity->created_at->format('d/m/Y') }}</p>
		<p>Author: {{ $entity->user->name }}</p>
		<div>
			{{ $entity->body }}
		</div>
	</div>
	<div class="article-comments">
		<h2>Comments</h2>
		<div class="row">
			<div class="col-sm-6">

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

				<form action="{{ route('blog.comment', ['article' => $entity->id]) }}" method="POST">
					{!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                        <label for="nickname" class="control-label">Nickname</label>

                        <input id="nickname" type="text" class="form-control" name="nickname" 
                        @guest
                        value="{{ old('nickname') }}"
                        @else
                        value="{{ old('nickname', Auth::user()->name) }}"
                        @endguest
                        required autofocus>

                        @if ($errors->has('nickname'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nickname') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                        <label for="comment" class="control-label">Comment</label>

                        <textarea id="comment" class="form-control" name="comment" required>{{ old('comment') }}</textarea>

                        @if ($errors->has('comment'))
                            <span class="help-block">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>

				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				@foreach($entity->comments as $comment)
					<p><b>{{ $comment->nickname }}</b>: {{ $comment->comment }}</p>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection