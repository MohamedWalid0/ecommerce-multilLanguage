<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionTranslationsTable extends Migration
{
  
    
    public function up()
    {
        Schema::create('option_translations', function (Blueprint $table) {
            
            $table->id();
            $table->integer('option_id')->unsigned();
            $table->string('locale');
            $table->string('name');
            $table->unique(['option_id', 'locale']);
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->timestamps();

        });
    }

  
    public function down()
    {
        Schema::dropIfExists('option_translations');
    }




}
