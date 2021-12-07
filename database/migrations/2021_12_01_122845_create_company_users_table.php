<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCompanyUsersTable
 */
class CreateCompanyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->on('users')
                ->references('id');
            $table->foreign('company_id')
                ->on('companies')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('company_users');
    }
}
