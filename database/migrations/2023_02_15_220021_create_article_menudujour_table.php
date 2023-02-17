<?php

use App\Models\Article;
use App\Models\MenuJour;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_menudujour', function (Blueprint $table) {
            $table->foreignIdFor(Article::class)->constrained();
            $table->foreignIdFor(MenuJour::class)->constrained();
            $table->primary(["article_id", "menu_jour_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_menudujour');
    }
};
