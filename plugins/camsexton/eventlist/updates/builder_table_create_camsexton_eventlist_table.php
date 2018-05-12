<?php namespace CamSexton\EventList\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCamsextonEventlistTable extends Migration
{
    public function up()
    {
        Schema::create('camsexton_eventlist_table', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->dateTime('datetime');
            $table->string('venue');
            $table->string('description');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('camsexton_eventlist_table');
    }
}
