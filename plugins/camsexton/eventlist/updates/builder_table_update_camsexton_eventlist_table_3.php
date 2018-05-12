<?php namespace CamSexton\EventList\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCamsextonEventlistTable3 extends Migration
{
    public function up()
    {
        Schema::table('camsexton_eventlist_table', function($table)
        {
            $table->text('description')->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('camsexton_eventlist_table', function($table)
        {
            $table->string('description', 191)->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
