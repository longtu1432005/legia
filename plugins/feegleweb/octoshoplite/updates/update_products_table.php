<?php namespace Feegleweb\OctoshopLite\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateProductsTable extends Migration
{
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
}
