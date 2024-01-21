<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create a temporal table
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->year('year');
            $table->string('genre', 50);
            $table->string('country', 30);
            $table->integer('duration');
            $table->string('img_url', 255);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    // Create a temporal table
        Schema::create('films_copy', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->year('year');
            $table->string('genre', 50);
            $table->string('country', 30);
            $table->integer('duration');
            $table->string('img_url', 255);
            $table->timestamps();
        });

        // Save data to a temporary JSON file
        $data = DB::table('films')->get()->toArray();
        $jsonData = json_encode($data);
        File::put(storage_path('app/temporary_data.json'), $jsonData);
        
        // Read data from the temporary JSON file
        $jsonData = File::get(storage_path('app/temporary_data.json'));
        $data = json_decode($jsonData, true);
        // Insert data into the original films table
        DB::table('films_copy')->insert($data);

        // Delete the temporary JSON file
        File::delete(storage_path('app/temporary_data.json'));

        // Drop  table
        Schema::dropIfExists('films');
    }
};
