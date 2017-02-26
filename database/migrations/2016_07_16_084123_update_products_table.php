<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('feegleweb_octoshop_products')) {
            Schema::table('feegleweb_octoshop_products', function ($table) {
                $table->string('sku')->nullable();
                $table->string('brand')->nullable();
                $table->string('keyword')->nullable();
                $table->text('seo_description')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
