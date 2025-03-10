@extends('layouts.app')

@section('title', 'Bienvenue')

@section('content')
<div class="welcome-container">
  <h2>Bienvenue sur la plateforme SportEvents</h2>
  <p>Créez, découvrez et participez à des événements sportifs de qualité !</p>
  @if (Auth::check())
    <p>Connecté en tant que <strong>{{ Auth::user()->name }}</strong>.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Accéder à votre Dashboard</a>
  @else
    <div class="auth-links">
      <a href="{{ route('login.form') }}" class="btn btn-primary">Se Connecter</a>
      <a href="{{ route('register.form') }}" class="btn btn-secondary">S'inscrire</a>
    </div>
  @endif
</div>
@endsection
