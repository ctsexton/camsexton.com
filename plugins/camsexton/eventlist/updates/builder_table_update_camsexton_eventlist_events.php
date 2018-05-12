<?php namespace CamSexton\EventList\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCamsextonEventlistEvents extends Migration
{
    public function up()
    {
        Schema::rename('camsexton_eventlist_table', 'camsexton_eventlist_events');
    }
    
    public function down()
    {
        Schema::rename('camsexton_eventlist_events', 'camsexton_eventlist_table');
    }
}
