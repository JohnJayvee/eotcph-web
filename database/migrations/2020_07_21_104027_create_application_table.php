<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->nullable();
            $table->string('reference_code')->nullable();
            $table->string('name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('purpose')->nullable();
            $table->string('department_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('status')->default("pending")->nullable();
            $table->text('directory')->nullable();
            $table->text('path')->nullable();
            $table->string('filename')->nullable();
            $table->string('source')->default("file")->nullable();
            $table->string('is_copy_check')->default("no")->nullable();
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
        Schema::dropIfExists('application');
    }
}
