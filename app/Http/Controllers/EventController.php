<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    // Afficher la liste avec filtres et pagination (5 par page)
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

    // Créer un événement (authentification requise)
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
        $event->user_id = $request->user()->id; // Lien avec l'utilisateur
        $event->save();

        return response()->json($event, 201);
    }

    // Afficher un événement par son ID
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    // Mettre à jour un événement (authentification requise)
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

    // Supprimer un événement (authentification requise)
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(null, 204);
    }

    // Afficher un événement via URL dynamique (slug et id)
    public function showBySlug($slug, $id)
    {
        $event = Event::where('id', $id)->where('slug', $slug)->firstOrFail();
        return response()->json($event);
    }
}
