<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('provider_id');
            $table->string('name', 128);
            $table->float('price',10,2);
            $table->string('avatar');
            $table->integer('num'); // number product
            $table->text('info');
            $table->integer('user_buy'); // number user buy
            $table->integer('view'); // number view
            $table->date('date_expire'); // date expire
            $table->boolean('del_flg');
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
        Schema::dropIfExists('products');
    }
}
