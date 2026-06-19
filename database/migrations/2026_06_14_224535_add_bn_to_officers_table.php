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
            Schema::table('officers', function (Blueprint $table) {
                // إضافة حقل B/N بعد حقل المعرف الخاص بالفرد
                $table->string('b_n')->nullable()->after('military_id'); 
            });
        }

    public function down()
        {
            Schema::table('officers', function (Blueprint $table) {
                $table->dropColumn('b_n');
            });
        }
};