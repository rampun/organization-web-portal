<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('file');
            $table->enum('visibility',['Public','Member'])->default('Member');
            $table->enum('status',['Publish','Draft'])->default('Publish');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('downloads');
        Schema::table('downloads', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
