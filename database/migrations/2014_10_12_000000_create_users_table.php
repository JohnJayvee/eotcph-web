<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('mname')->nullable();
            $table->string('suffix')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            $table->string('street_name')->nullable();
            $table->string('unit_number')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('tin_no')->nullable();
            $table->string('sss_no')->nullable();
            $table->string('phic_no')->nullable();

            $table->string('email')->nullable();
            $table->string('username')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('password')->nullable();
            $table->string('code')->nullable();
            $table->string('active')->default(0)->nullable();
            $table->string('type')->default("admin")->nullable();
            $table->string('status')->default("active")->nullable();
            $table->timestamp('last_login_at')->nullable();

            //avatar holder
            $table->text('directory')->nullable();
            $table->text('path')->nullable();
            $table->string('filename')->nullable();
            $table->string('source')->default("file")->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
