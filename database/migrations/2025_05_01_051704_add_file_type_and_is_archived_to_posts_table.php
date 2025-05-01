<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileTypeAndIsArchivedToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Menambahkan kolom file_type jika belum ada
            if (!Schema::hasColumn('posts', 'file_type')) {
                $table->enum('file_type', ['image', 'video'])->default('image');
            }

            // Menambahkan kolom is_archived jika belum ada
            if (!Schema::hasColumn('posts', 'is_archived')) {
                $table->boolean('is_archived')->default(false);
            }
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Menghapus kolom file_type dan is_archived
            $table->dropColumn('file_type');
            $table->dropColumn('is_archived');
        });
    }
}
