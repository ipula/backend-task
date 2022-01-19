<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name',500)->nullable();
            $table->string('email',500)->nullable();
            $table->string('avatar_url',500)->nullable();
            $table->string('location',500)->nullable();
            $table->string('login_name',500)->nullable();
            $table->date('join_date')->nullable();
            $table->integer('followers')->nullable();
            $table->integer('repo_count')->nullable();
            $table->integer('followings')->nullable();
            $table->integer('public_repos')->nullable();
            $table->integer('public_gists')->nullable();
            $table->bigInteger('detail_requested')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_accounts');
    }
}
