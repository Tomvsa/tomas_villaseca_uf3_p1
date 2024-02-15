<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Models\Film;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{

    public static function readFilms(): array
    {
        // Retrieve all films from the database using Query Builder
        $filmsFromDatabase = DB::table('films')->get()->toArray();
        $filmsFromDatabase = json_decode(json_encode($filmsFromDatabase), true);
        // Retrieve films from the JSON file
        $filmsFromJson = Storage::json('/public/films.json');
        // Merge films from the database and JSON file
        $arrayFilms = array_merge($filmsFromDatabase, $filmsFromJson);
        return $arrayFilms;
    }

    /**
     * List films older than input year 
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listOldFilms($year = null)
    {
        $old_films = [];
        if (is_null($year))
            $year = 2000;

        $title = "Listado de Pelis Antiguas (Antes de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] < $year)
                $old_films[] = $film;
        }
        return view('films.list', ["films" => $old_films, "title" => $title]);
    }
    /**
     * List films younger than input year
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listNewFilms($year = null)
    {
        $new_films = [];
        if (is_null($year))
            $year = 2000;

        $title = "Listado de Pelis Nuevas (Después de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] >= $year)
                $new_films[] = $film;
        }
        return view('films.list', ["films" => $new_films, "title" => $title]);
    }

    /**
     * List all films or filter by year or genre
     */
    public function listFilms($year = null, $genre = null)
    {
        $films_filtered = [];
        $title = "Listado de todas las pelis";
        $films = FilmController::readFilms();

        $currentPage = request()->get('page', 1); // Get actual page
        $perPage = 5; // number films per page


        //if year and genre are null
        if (is_null($year) && is_null($genre))
            // return view('films.list', ["films" => $films, "title" => $title]);

        //list based on year or genre informed
        foreach ($films as $film) {
            if ((!is_null($year) && is_null($genre)) && $film['year'] == $year) {
                $title = "Listado de todas las pelis filtrado x año";
                $films_filtered[] = $film;
            } else if ((is_null($year) && !is_null($genre)) && strtolower($film['genre']) == strtolower($genre)) {
                $title = "Listado de todas las pelis filtrado x categoria";
                $films_filtered[] = $film;
            } else if (!is_null($year) && !is_null($genre) && strtolower($film['genre']) == strtolower($genre) && $film['year'] == $year) {
                $title = "Listado de todas las pelis filtrado x categoria y año";
                $films_filtered[] = $film;
            }
        }
        $totalPages = intval(ceil(count($films) / $perPage));
        // Slice films for the current page
        $paginatedFilms = array_slice($films, ($currentPage - 1) * $perPage, $perPage);
        return view("films.list", [
            "title" => $title,
            "currentPage" => $currentPage,
            "perPage" => $perPage,
            "totalPages" => $totalPages,
            "paginatedFilms" => $paginatedFilms
        ]);
    }

    /**
     * List films by a specific year
     */
    public function listFilmsByYear($year = null)
    {
        $films_filtered = [];

        $title = "Listado de Pelis por Año";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if (!is_null($year) && $film['year'] == $year) {
                $films_filtered[] = $film;
            }
        }
        // Returns a view with the list of films for the given year
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    /**
     * List films by a specific genre
     */
    public function listFilmsByGenre($genre = null)
    {
        $films_filtered = [];

        $title = "Listado de Pelis por Categoría";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if (!is_null($genre) && strtolower($film['genre']) == strtolower($genre)) {
                $films_filtered[] = $film;
            }
        }
        // Returns a view with the list of films for the given genre
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    /**
     * List all films sorted by year in descending order
     */
    public function sortFilms()
    {
        $sorted_films = [];
        $title = "Listado de Pelis Ordenadas por Año (de más nuevo a más antiguo)";

        $films = FilmController::readFilms();

        // Sort films by year in descending order
        usort($films, function ($a, $b) {
            return $b['year'] - $a['year'];
        });

        $sorted_films = $films;
        // Returns a view with the sorted list of films
        return view('films.list', ["films" => $sorted_films, "title" => $title]);
    }

    /**
     * Count and display the total number of films
     */
    public function countFilms()
    {
        $films = FilmController::readFilms();
        $total_films = count($films);
        $title = "Número total de Películas";
        // Returns a view with the total count of films
        return view('films.counter', ["total_films" => $total_films, "title" => $title]);
    }

    /**
     * Create a new film based on the request data
     * @param Request $request
     */
    public function createFilm(Request $request)
    {
        $filmData = [
            'name' => $request->input('name'),
            'year' => $request->input('year'),
            'genre' => $request->input('genre'),
            'country' => $request->input('country'),
            'duration' => $request->input('duration'),
            'img_url' => $request->input('img_url'),
            'created_at' => now(),
            'updated_at' => now()
        ];

        if ($_ENV['USE_DATABASE'] == 'SQL') {
            // Film does not exist, add it and show all films
            if (!$this->isFilm($filmData['name'])) {
                // Save the film data to the database using Query Builder
                DB::table('films')->insert($filmData);
                // Return the view of the form with a success message
                return $this->listFilms()->with('success', 'Film added successfully.');
            } else {
                // Film already exists, go back to the form with an error message
                return redirect('/')->with('error', 'Film already exists');
            }
        } else {
            if (!$this->isFilm($filmData['name'])) {
                // Film does not exist, add it and show all films
                $films = $this->readFilms();
                $films[] = $filmData;

                // Save the updated films array to the JSON file
                Storage::put('/public/films.json', json_encode($films));

                // Return the view of the form with a success message
                return $this->listFilms()->with('success', 'Film added successfully.');
            } else {
                // Film already exists, go back to the form with an error message
                return redirect('/')->with('error', 'Film already exists');
            }
        }
    }


    /**
     * Check if a film with the given name already exists
     */
    public function isFilm($filmName): bool
    {
        $films = $this->readFilms();
        foreach ($films as $film) {
            if (strtolower($film['name']) === strtolower($filmName)) {
                // Film name already exists
                return true;
            }
        }
        // Film name does not exist
        return false;
    }

    /**
     * Get all films via http:
     * localhost:8000/api/films
     * @return \Response
     */
    public function getFilms()
    {
        $films = DB::table('films')
            ->get()
            ->toArray();
        $films= json_decode(json_encode($films), true);
    
        $film_actors = DB::Table('film_actors')->get()->toArray();
        $film_actors = json_decode(json_encode($film_actors), true);
        foreach ($films as &$film) { // Note the "&" before $film
            $film['actors'] = [];
            foreach ($film_actors as $film_actor) {
                if ($film_actor['film_id'] === $film['id']) {
                    $actor = DB::table('actors')->where('id', $film_actor['actor_id'])->first();
                    $actor = json_decode(json_encode($actor), true);
                    $film['actors'][] = $actor;
                }
            }
        }
    
       return  response()->json(['films' => $films]);
    }
}
