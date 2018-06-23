<?php namespace CamSexton\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCamsextonPortfolioItems2 extends Migration
{
    public function up()
    {
        Schema::table('camsexton_portfolio_items', function($table)
        {
            $table->integer('sort_order')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('camsexton_portfolio_items', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
}
