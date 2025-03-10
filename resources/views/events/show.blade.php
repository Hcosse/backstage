@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="event-detail">
  <h1>{{ $event->title }}</h1>
  <p class="event-description">{{ $event->description }}</p>
  <ul class="event-meta">
    <li><strong>Date :</strong> {{ $event->date }}</li>
    <li><strong>Lieu :</strong> {{ $event->location }}</li>
    <li><strong>Catégorie :</strong> {{ $event->category }}</li>
    <li><strong>Places max :</strong> {{ $event->max_participants }}</li>
  </ul>
</div>
@endsection
