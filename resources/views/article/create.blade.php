@extends('layouts.app')

@section('content')

@component('article.form', [
'formTitle' => 'Create Article', 
'formAction' => 'articles.store',
'entity' => $entity,
'formMethod' => 'POST',
])
@endcomponent

@endsection