@extends('layouts.app')

@section('title', 'Créer un Événement')

@section('content')
<div class="form-container">
  <h2>Créer un nouvel Événement</h2>
  @if ($errors->any())
    <div class="alert alert-error">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('events.store') }}" method="POST" class="form">
    @csrf
    <div class="form-group">
      <label for="title">Titre :</label>
      <input type="text" name="title" id="title" placeholder="Titre de l'événement" value="{{ old('title') }}" required>
    </div>
    <div class="form-group">
      <label for="description">Description :</label>
      <textarea name="description" id="description" placeholder="Description de l'événement" required>{{ old('description') }}</textarea>
    </div>
    <div class="form-group">
      <label for="location">Lieu :</label>
      <input type="text" name="location" id="location" placeholder="Lieu de l'événement" value="{{ old('location') }}" required>
    </div>
    <div class="form-group">
      <label for="date">Date :</label>
      <input type="date" name="date" id="date" value="{{ old('date') }}" required>
    </div>
    <div class="form-group">
      <label for="category">Catégorie :</label>
      <input type="text" name="category" id="category" placeholder="Catégorie de l'événement" value="{{ old('category') }}" required>
    </div>
    <div class="form-group">
      <label for="max_participants">Participants max :</label>
      <input type="number" name="max_participants" id="max_participants" placeholder="Nombre maximum de participants" value="{{ old('max_participants') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Créer l'événement</button>
  </form>
</div>
@endsection
