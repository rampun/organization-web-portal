<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_metas', function (Blueprint $table) {
            $table->id();
            // foreign key
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('membership_type')->nullable();
            $table->string('membership_no')->nullable();
            $table->string('family_name')->nullable();
            // $table->string('full_name')->nullable();
            $table->string('job')->nullable();
            $table->string('address_np')->nullable();
            $table->string('district_np')->nullable();
            $table->string('province_np')->nullable();
            $table->string('address_hk')->nullable();
            $table->string('district_hk')->nullable();
            $table->string('region_hk')->nullable();
            $table->string('document_type')->nullable();
            $table->text('document_no')->nullable();
            $table->string('member_photo')->nullable();
            $table->string('telephone_no')->nullable();
            $table->string('mobile_no')->nullable();;
            $table->date('issue_date')->nullable();;
            $table->date('expiry_date')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_job')->nullable();
            $table->string('spouse_photo')->nullable();
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
        // Schema::dropIfExists('user_metas');
        Schema::table('user_metas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
