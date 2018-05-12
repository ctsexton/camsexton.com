<?php namespace CamSexton\EventList\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCamsextonEventlistTable extends Migration
{
    public function up()
    {
        Schema::table('camsexton_eventlist_table', function($table)
        {
            $table->string('title')->nullable()->change();
            $table->dateTime('datetime')->nullable()->change();
            $table->string('venue')->nullable()->change();
            $table->string('description')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('camsexton_eventlist_table', function($table)
        {
            $table->string('title')->nullable(false)->change();
            $table->dateTime('datetime')->nullable(false)->change();
            $table->string('venue')->nullable(false)->change();
            $table->string('description')->nullable(false)->change();
        });
    }
}
