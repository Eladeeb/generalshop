<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('image_direction')->default('left');
            $table->string('image_url')->default('https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcRgCj_1MdkGe_z-J4Ln4I7vsRh-HYLSVseT4smqAyO3uN1ny-bo');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('image_direction');
            $table->dropColumn('image_url');
        });
    }
}
