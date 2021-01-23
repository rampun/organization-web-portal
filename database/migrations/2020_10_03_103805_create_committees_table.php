<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->date('tenure_start_date');
            $table->date('tenure_end_date')->nullable();
            
            // foreign key
            $table->unsignedBigInteger('president');
            $table->foreign('president')->references('id')->on('users');

            // foreign key
            $table->unsignedBigInteger('first_vc_president');
            $table->foreign('first_vc_president')->references('id')->on('users');

            // foreign key
            $table->unsignedBigInteger('second_vc_president')->nullable();
            $table->foreign('second_vc_president')->references('id')->on('users');

            // foreign key
            $table->unsignedBigInteger('general_secretary');
            $table->foreign('general_secretary')->references('id')->on('users');

            // foreign key
            $table->unsignedBigInteger('secretary')->nullable();
            $table->foreign('secretary')->references('id')->on('users');

            // foreign key
            $table->unsignedBigInteger('treasurer');
            $table->foreign('treasurer')->references('id')->on('users');

            // foreign key
            $table->unsignedBigInteger('vc_treasurer')->nullable();
            $table->foreign('vc_treasurer')->references('id')->on('users');

            $table->json('members')->nullable();

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
        // Schema::dropIfExists('committees');
        Schema::table('committees', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
