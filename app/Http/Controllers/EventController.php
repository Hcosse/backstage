<?php

namespace App\Http\Controllers;

use App\Models\Event;     
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Pour l'API : liste paginée des événements
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        if ($request->has('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }
        if ($request->has('date')) {
            $query->where('date', $request->date);
        }

        $events = $query->paginate(5);
        return response()->json($events);
    }

    // Création d'un événement (API et Web)
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string',
            'description'      => 'required|string',
            'location'         => 'required|string',
            'date'             => 'required|date',
            'category'         => 'required|string',
            'max_participants' => 'required|integer',
        ]);

        $event = new Event($request->all());
        $event->slug = Str::slug($request->title);
        $event->user_id = Auth::id();
        $event->save();

        // Pour API, on renvoie du JSON
        if ($request->wantsJson()) {
            return response()->json($event, 201);
        }

        return redirect()->route('dashboard')->with('success', 'Événement créé avec succès !');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title'            => 'sometimes|required|string',
            'description'      => 'sometimes|required|string',
            'location'         => 'sometimes|required|string',
            'date'             => 'sometimes|required|date',
            'category'         => 'sometimes|required|string',
            'max_participants' => 'sometimes|required|integer',
        ]);

        $event->update($request->all());
        if ($request->has('title')) {
            $event->slug = Str::slug($request->title);
            $event->save();
        }

        return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(null, 204);
    }

    public function showBySlug($slug, $id)
    {
        $event = Event::where('id', $id)->where('slug', $slug)->firstOrFail();
        return response()->json($event);
    }

    /*
    |--------------------------------------------------------------------------
    | Méthodes pour les vues Blade (WEB)
    |--------------------------------------------------------------------------
    */

    // Liste paginée des événements (vue publique)
    public function indexView(Request $request)
    {
        $query = Event::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        if ($request->has('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }
        if ($request->has('date')) {
            $query->where('date', $request->date);
        }

        $events = $query->paginate(5);
        return view('events.index', compact('events'));
    }

    // Affichage d'un événement (vue publique)
    public function showView($slug, $id)
    {
        $event = Event::where('slug', $slug)->where('id', $id)->firstOrFail();
        return view('events.show', compact('event'));
    }

    // Affichage du formulaire de création d'un événement
    public function create()
    {
        return view('events.create');
    }

    // Dashboard personnalisé pour l'utilisateur connecté
    public function dashboard(Request $request)
    {
        $userId = Auth::id();

        $myEvents = Event::where('user_id', $userId)
                         ->orderBy('created_at', 'desc')
                         ->get();

        $allEvents = Event::orderBy('created_at', 'desc')->paginate(5);

        return view('events.dashboard', compact('myEvents', 'allEvents'));
    }

    // Affichage du formulaire d'édition d'un événement (seulement pour son propriétaire)
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }
        return view('events.edit', compact('event'));
    }

    // Traitement de la mise à jour d'un événement via le formulaire web
    public function updateWeb(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'title'            => 'required|string',
            'description'      => 'required|string',
            'location'         => 'required|string',
            'date'             => 'required|date',
            'category'         => 'required|string',
            'max_participants' => 'required|integer',
        ]);

        $event->update($request->all());
        if ($request->has('title')) {
            $event->slug = Str::slug($request->title);
            $event->save();
        }

        return redirect()->route('dashboard')->with('success', 'Événement mis à jour.');
    }
}
