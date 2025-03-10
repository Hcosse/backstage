@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="form-container">
  <h2>Inscription</h2>
  @if ($errors->any())
    <div class="alert alert-error">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('register.submit') }}" method="POST" class="form">
    @csrf
    <div class="form-group">
      <label for="name">Nom :</label>
      <input type="text" name="name" id="name" placeholder="Votre nom" value="{{ old('name') }}" required>
    </div>
    <div class="form-group">
      <label for="email">Email :</label>
      <input type="email" name="email" id="email" placeholder="Votre email" value="{{ old('email') }}" required>
    </div>
    <div class="form-group">
      <label for="password">Mot de passe :</label>
      <input type="password" name="password" id="password" placeholder="Votre mot de passe" required>
    </div>
    <div class="form-group">
      <label for="password_confirmation">Confirmez le mot de passe :</label>
      <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmez votre mot de passe" required>
    </div>
    <button type="submit" class="btn btn-primary">S'inscrire</button>
  </form>
</div>
@endsection
