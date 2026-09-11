<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('books', 'book_file')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('book_file')->after('cover_image');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('books', 'book_file')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('book_file');
            });
        }
    }
};
