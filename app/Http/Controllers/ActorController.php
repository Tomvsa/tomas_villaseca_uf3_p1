<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class ActorController extends Controller
{
     /**
     * Retrieve all actors from the database.
     * @return array
     */
    public function readActors(): array
    {
        $actors = DB::table('actors')->select('*')->get();
        return $actors->toArray();
    }

    /**
     * Display a list of all actors.
     * @return \Illuminate\View\View
     */
    public function listActors(){
        $actors = json_decode(json_encode($this->readActors()), true);  
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
    
        $actors = DB::table('actors')
            ->select('*')
            ->whereBetween('birthdate', [$startYear . '-01-01', $endYear . '-12-31'])
            ->get()
            ->toArray();
        $actors = json_decode(json_encode($actors), true);
        return view('actors.list', ["actors" => $actors, "title" => "Actor List by decade"]);
    }
    
    /**
     * Display the total number of actors.
     * @return \Illuminate\View\View
     */
    public function countActors()
    {
        $actorCount = DB::table('actors')->count();
        return view('actors.counter', ["total_actors" => $actorCount, "title" => "total actors number"]);
    }

    /**
     * Create a new actor.
     * @param Request $request
     */
    public function createActor(Request $request){
        $actorData = [
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'birthdate' => $request->input('country'),
            'img_url' => $request->input('img_url')
        ];

        if(!$this->isActor($actorData['name'])){
            DB::table('actos')->insert($actorData);
            //return  
        }else{
            return redirect('')->with('error', 'Actor already exists');
        }
    }


    /**
     * Check if a actor with the given name already exists
     * @param string $actorName
     */
    public function isActor($actorName)
    {
        $actors = $this->readActors();
        foreach ($actors as $actor) {
            if (strtolower($actor['name']) === strtolower($actorName)) {
                // Film name already exists
                return true;
            }
        }
        // Actor name does not exist
        return false;
    }

    /**
     * Delete an actor by ID.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteActor($id)
{
    $actor = DB::table('actors')->find($id);
    if (!$actor) {
        return response()->json(['action' => 'delete', 'status' => false, 'error' => 'Actor not found']);
    }
    try {
        DB::table('actors')->where('id', $id)->delete();
        return response()->json(['action' => 'delete', 'status' => true]);
    } catch (\Exception $e) {
        return response()->json(['action' => 'delete', 'status' => false, 'error' => $e->getMessage()]);
    }
}
}
