<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actor;

class ActorController extends Controller
{
    /**
     * Retrieve all actors from the database.
     * @return array
     */
    public function readActors(): array
    {
        return Actor::all()->toArray();
    }

    /**
     * Display a list of all actors.
     * @return \Illuminate\View\View
     */
    public function listActors()
    {
        $actors = $this->readActors();
        return view('actors.list', ["actors" => $actors, "title" => "Actor List"]);
    }

    /**
     * Display a list of actors born within a specific decade.
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function listActorsByDecade(Request $request)
    {
        $startYear = $request->input('year');
        $endYear = $startYear + 9;
        
        $actors = Actor::whereBetween('birthdate', [$startYear . '-01-01', $endYear . '-12-31'])->get()->toArray();
        
        return view('actors.list', ["actors" => $actors, "title" => "Actor List by decade"]);
    }
    
    /**
     * Display the total number of actors.
     * @return \Illuminate\View\View
     */
    public function countActors()
    {
        $actorCount = Actor::count();
        return view('actors.counter', ["total_actors" => $actorCount, "title" => "total actors number"]);
    }

    /**
     * Create a new actor.
     * @param Request $request
     */
    public function createActor(Request $request)
    {
        $actorData = $request->only(['name', 'surname', 'birthdate', 'country', 'img_url']);

        if (!$this->isActor($actorData['name'])) {
            Actor::create($actorData);
            //return  
        } else {
            return redirect('')->with('error', 'Actor already exists');
        }
    }

    /**
     * Check if an actor with the given name already exists
     * @param string $actorName
     */
    public function isActor($actorName)
    {
        return Actor::where('name', 'LIKE', $actorName)->exists();
    }

    /**
     * Delete an actor by ID.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteActor($id)
    {
        $actor = Actor::find($id);
        if (!$actor) {
            return response()->json(['action' => 'delete', 'status' => false, 'error' => 'Actor not found']);
        }
        try {
            $actor->delete();
            return response()->json(['action' => 'delete', 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['action' => 'delete', 'status' => false, 'error' => $e->getMessage()]);
        }
    }
}
