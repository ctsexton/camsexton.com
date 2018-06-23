<?php namespace CamSexton\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCamsextonPortfolioItems extends Migration
{
    public function up()
    {
        Schema::rename('camsexton_portfolio_', 'camsexton_portfolio_items');
        Schema::table('camsexton_portfolio_items', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
    
    public function down()
    {
        Schema::rename('camsexton_portfolio_items', 'camsexton_portfolio_');
        Schema::table('camsexton_portfolio_', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
}
