@extends('layouts.app')

@section('content')

@component('article.form', [
'formTitle' => 'Edit Article', 
'formAction' => 'articles.update',
'entity' => $entity,
'formMethod' => 'PUT',
])
@endcomponent

@endsection