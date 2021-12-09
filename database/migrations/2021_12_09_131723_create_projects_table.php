<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateProjectsTable
 */
class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('system_name', 255);
            $table->string('name', 500);
            $table->string('access_key', 50);
            $table->boolean('is_enabled')->default(true);
            $table->unsignedBigInteger('user_owner_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_owner_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['user_owner_id']);
        });

        Schema::dropIfExists('projects');
    }
}
