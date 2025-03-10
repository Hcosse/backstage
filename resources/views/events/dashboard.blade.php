@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard">
  <h2>Bienvenue, {{ auth()->user()->name }} !</h2>

  <div class="dashboard-tabs">
    <button class="tablink active" onclick="openTab(event, 'myEvents')">Mes Événements</button>
    <button class="tablink" onclick="openTab(event, 'allEvents')">Événements en cours</button>
  </div>

  <div id="myEvents" class="tabcontent" style="display: block;">
    @if($myEvents->isEmpty())
      <p>Vous n'avez pas encore créé d'événements.</p>
      <a href="{{ route('events.create') }}" class="btn btn-primary">Créer un événement</a>
    @else
      <ul class="event-list">
        @foreach($myEvents as $event)
          <li>
            <div class="event-info">
              <strong>{{ $event->title }}</strong>
              <div class="event-actions">
                <a href="{{ route('events.show', [$event->slug, $event->id]) }}" class="btn btn-secondary">Voir</a>
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-secondary">Modifier</a>
              </div>
            </div>
            <form action="{{ route('events.delete', $event->id) }}" method="POST" class="inline-form">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous supprimer cet événement ?')">Supprimer</button>
            </form>
          </li>
        @endforeach
      </ul>
    @endif
  </div>

  <div id="allEvents" class="tabcontent" style="display: none;">
    @if($allEvents->isEmpty())
      <p>Aucun événement n’est disponible pour le moment.</p>
    @else
      <ul class="event-list">
        @foreach($allEvents as $event)
          <li>
            <div class="event-info">
              <strong>{{ $event->title }}</strong>
              <span class="event-author">par {{ $event->user->name ?? 'Anonyme' }}</span>
              <a href="{{ route('events.show', [$event->slug, $event->id]) }}" class="btn btn-secondary">Voir</a>
            </div>
          </li>
        @endforeach
      </ul>
      <div class="pagination">
        {{ $allEvents->links() }}
      </div>
    @endif
    <a href="{{ route('events.create') }}" class="btn btn-primary">Créer un nouvel événement</a>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function openTab(evt, tabName) {
    let tabcontent = document.getElementsByClassName("tabcontent");
    for (let i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    let tablinks = document.getElementsByClassName("tablink");
    for (let i = 0; i < tablinks.length; i++) {
      tablinks[i].classList.remove("active");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.classList.add("active");
  }
</script>
@endsection
