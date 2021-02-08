@extends('app')

@section('title', $user->name . 'のフォロワー')

@section('content')
  @include('nav')
  <div class="container">
  @include('users.user')
  @include('users.tab', ['hasArticles' => false, 'hasLikes' => false])
  @foreach($followees as $person)
  @include('users.person')
  @endforeach
  </div>
@endsection