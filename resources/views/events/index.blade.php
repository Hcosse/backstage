@extends('layouts.app')

@section('title', 'Liste des Événements')

@section('content')
<div class="events-index">
  <h2>Liste des Événements</h2>
  @if($events->isEmpty())
    <p>Aucun événement n'est disponible.</p>
  @else
    <ul class="event-list">
      @foreach($events as $event)
        <li>
          <div class="event-info">
            <strong>{{ $event->title }}</strong>
            <p>{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
            <a href="{{ route('events.show', [$event->slug, $event->id]) }}" class="btn btn-secondary">Voir le détail</a>
          </div>
        </li>
      @endforeach
    </ul>
    <div class="pagination">
      {{ $events->links() }}
    </div>
  @endif
</div>
@endsection
