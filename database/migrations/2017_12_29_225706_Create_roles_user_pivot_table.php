<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'role_user',
            function (Blueprint $table) {
                $table->integer('user_id')->unsigned();
                $table->integer('role_id')->unsigned();
                $table->timestamps();
                $table->engine = 'InnoDB';
            }
            );
        Schema::table(
            'role_user',
            function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            }
            );
        Schema::table(
            'role_user',
            function (Blueprint $table)
            {
                $table->index('user_id');
                $table->index('role_id');
        }
        );
               
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'role_user',
            function (Blueprint $table)
            {
                $table->dropForeign('role_user_user_id_foreign');
                $table->dropForeign('role_user_role_id_foreign');
                $table->dropIndex('role_user_user_id_index');
                $table->dropIndex('role_user_role_id_index');
        }
        );
        
        Schema::drop('role_user');
    }
}
