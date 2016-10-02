<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookTransactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId');
            $table->string('bookId');
            $table->string('penalty');
            $table->date('dateBorrowed');
            $table->date('dateReturned');
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
        Schema::drop('bookTransactions');
    }
}
