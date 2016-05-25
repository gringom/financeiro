<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('account_id')->unsigned()->index();
            $table->integer('category_id')->unsigned()->index();
            $table->integer('person_id')->unsigned()->index();
            $table->integer('project_id')->unsigned()->index();
            $table->enum('type', ['entrada', 'saida', 'a_receber', 'a_pagar']);
            $table->decimal('value', 13, 4);
            $table->date('payment_date');
            $table->date('paid_date');
            $table->text('description');
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
        Schema::drop('records');
    }
}
