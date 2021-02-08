@extends('app')

@section('title', $user->name . 'のフォロー中')

@section('content')
  @include('nav')
  <div class="container">
  @include('users.user')
  @include('users.tab', ['hasArticles' => false, 'hasLikes' => false])
  @foreach($followers as $person)
  @include('users.person')
  @endforeach
  </div>
@endsection