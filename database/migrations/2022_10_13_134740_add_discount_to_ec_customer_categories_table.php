<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToEcCustomerCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ec_flash_sale_products_category', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->index();
            $table->integer('flash_sale_id')->unsigned()->index();
            $table->double('discount',8,2)->default(0);
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
       
        Schema::dropIfExists('ec_flash_sale_products_category');
    }
}
