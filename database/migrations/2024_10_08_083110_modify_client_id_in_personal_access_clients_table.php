<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Mengubah tipe data client_id di tabel oauth_personal_access_clients
        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            $table->char('client_id', 36)->change();
        });

        // Mengubah tipe data id di tabel oauth_clients
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->char('id', 36)->change();
        });

        // Mengubah tipe data client_id di tabel oauth_auth_codes
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->char('client_id', 36)->change();
        });

        // Mengubah tipe data client_id di tabel oauth_access_tokens
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->char('client_id', 36)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Mengembalikan tipe data client_id di tabel oauth_personal_access_clients
        Schema::table('oauth_personal_access_clients', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->change();
        });

        // Mengembalikan tipe data id di tabel oauth_clients
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        // Mengembalikan tipe data client_id di tabel oauth_auth_codes
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->change();
        });

        // Mengembalikan tipe data client_id di tabel oauth_access_tokens
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->change();
        });
    }
};
