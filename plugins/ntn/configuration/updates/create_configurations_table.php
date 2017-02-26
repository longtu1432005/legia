<?php namespace Ntn\Configuration\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateConfigurationsTable extends Migration
{

    public function up()
    {
        Schema::create('configurations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('key')->unique();
            $table->text('value');
            $table->text('description')->nullable();
            $table->boolean('core')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configurations');
    }

}
