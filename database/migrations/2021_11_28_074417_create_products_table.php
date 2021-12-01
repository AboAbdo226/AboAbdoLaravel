<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   Schema::dropIfExists('product');
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');  /// this is very hard to work with -> unsigned() so this is better
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("name");
            $table->string("catagory");
            $table->longText("description")->nullable();
            $table->string("contact");
            $table->decimal("price",8,2);
            $table->decimal("discounted_price",8,2)->nullable();
            $table->integer("fifty_thirty");
            $table->integer("thirty_fifteen");
            $table->integer("fifteen_zero");
            $table->integer("quantity");
            $table->string("image_src")->nullable();
            $table->date("expired_date");
            $table->integer("views")->nullable();
            ///// coments
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   Schema::dropIfExists('like');
        Schema::dropIfExists('comment');
        Schema::dropIfExists('product');
    }
}
