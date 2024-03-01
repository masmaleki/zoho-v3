<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
//  id varchar(255) NOT NULL,
//  user_mail varchar(255) NOT NULL,
//  client_id varchar(255),
//  client_secret varchar(255),
//  refresh_token varchar(255),
//  access_token varchar(255),
//  grant_token varchar(255),
//  expiry_time varchar(20),
//  redirect_url varchar(255),
//  primary key (id)
    public function up()
    {
        Schema::create('zoho_v4', function (Blueprint $table) {
            $table->id();
            $table->string('user_mail')->nullable();
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('access_token')->nullable();
            $table->string('grant_token');
            $table->string('token_type')->nullable();
            $table->string('expiry_time',20);
            $table->string('accounts_url')->nullable();
            $table->string('api_domain')->nullable();
            $table->string('redirect_url')->nullable();
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
        Schema::dropIfExists('zoho_v4');
    }
};
