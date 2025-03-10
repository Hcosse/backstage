@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="form-container">
  <h2>Connexion</h2>
  @if ($errors->any())
    <div class="alert alert-error">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('login.submit') }}" method="POST" class="form">
    @csrf
    <div class="form-group">
      <label for="email">Email :</label>
      <input type="email" name="email" id="email" placeholder="Votre email" value="{{ old('email') }}" required>
    </div>
    <div class="form-group">
      <label for="password">Mot de passe :</label>
      <input type="password" name="password" id="password" placeholder="Votre mot de passe" required>
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
  </form>
</div>
@endsection
