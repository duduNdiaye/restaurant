<?php

use App\Models\Article;
use App\Models\MenuJour;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_menu_jour', function (Blueprint $table) {
            //
            $table->dropForeign('article_id');
            $table->dropForeign('menu_jour_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_menudujour', function (Blueprint $table) {
            $table->foreignIdFor(Article::class)->constrained()->onDelete('CASCADE');
            //
            $table->foreignIdFor(MenuJour::class)->constrained()->onDelete('CASCADE');
            //
        });
    }
};
