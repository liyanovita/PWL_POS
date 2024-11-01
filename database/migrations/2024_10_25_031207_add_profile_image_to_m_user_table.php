<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileImageToMUserTable extends Migration
{
    public function up()
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->after('password'); // Ganti 'avatar' dengan nama kolom sebelum 'profile_image' jika perlu
        });
    }

    public function down()
    {
        Schema::table('m_user', function (Blueprint $table) {
            $table->dropColumn('profile_image');
        });
    }
}

