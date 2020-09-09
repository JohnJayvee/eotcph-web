<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id')->nullable();
            $table->string('application_payment_reference')->nullable();
            $table->string('application_payment_type')->nullable();
            $table->string('application_payment_option')->nullable();
            $table->string('application_payment_method')->nullable();
            $table->string('application_payment_status')->default("UNPAID")->nullable();
            $table->string('application_transaction_status')->default("PENDING")->nullable();
            $table->string('application_total_amount')->nullable();
            $table->string('application_convenience_fee')->nullable();
            $table->string('application_payement_date')->timestamps();
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
        Schema::dropIfExists('application_transaction');
    }
}
