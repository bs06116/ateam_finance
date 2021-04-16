<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('projects') ) {
            DB::statement("
                CREATE TABLE `password_resets` (
                  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  KEY `password_resets_email_index` (`email`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
