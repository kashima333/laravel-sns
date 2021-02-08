@extends('app')
@section('title',$user->name)
@section('content')
@include('nav')
<div class="container">
@include('users.user')
@include('users.tab',['hasArticles'=>true,'hasLikes'=>false])
    @foreach($articles as $article)
    @include('articles.card')
    @endforeach
</div>
@endsection