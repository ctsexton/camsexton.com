<?php namespace CamSexton\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCamsextonPortfolio extends Migration
{
    public function up()
    {
        Schema::create('camsexton_portfolio_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('url')->nullable();
            $table->string('code_url')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('camsexton_portfolio_');
    }
}
