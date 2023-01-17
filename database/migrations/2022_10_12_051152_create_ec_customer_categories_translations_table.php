<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcCustomerCategoriesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ec_customer_categories_translations');

        
        Schema::create('ec_customer_categories_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->integer('ec_customer_categories_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->primary(['lang_code', 'ec_customer_categories_id'], 'ec_customer_categories_translations_primary');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ec_customer_categories_translations');
    }
}
