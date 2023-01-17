<?php

use Botble\Ecommerce\Models\OrderReturn;
use Botble\Ecommerce\Models\OrderReturnItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableOrderReturns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ec_order_returns', function (Blueprint $table) {
            $table->string('code')->after('id')->unique()->nullable();
        });

        foreach (OrderReturn::get() as $orderReturn) {
            $orderReturn->code = get_order_code($orderReturn->id);
            $orderReturn->save();
        }

        Schema::table('ec_order_return_items', function (Blueprint $table) {
            $table->string('product_image')->after('product_name')->nullable();
        });

        foreach (OrderReturnItem::with('product')->get() as $orderReturnItem) {
            $orderReturnItem->product_image = $orderReturnItem->product->image ?: $orderReturnItem->product->original_product->image;
            $orderReturnItem->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ec_order_return_items', function (Blueprint $table) {
            //
        });
    }
}
