<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanBoardModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('loan_no');
            $table->bigInteger('user_id')->unsigned();
            $table->double('amount')->default(0);
            $table->double('balance')->default(0);
            $table->integer('rate')->default(0);
            $table->double('monthly_payment')->default(0);
            $table->bigInteger('created_by')->unsigned();
            $table->integer('state')->default(0)->unsigned();
            $table->date('start_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('loan_boards');
    }
}
