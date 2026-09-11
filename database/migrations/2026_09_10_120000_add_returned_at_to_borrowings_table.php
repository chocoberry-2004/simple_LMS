<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('borrowings', 'returned_at')) {
            Schema::table('borrowings', function (Blueprint $table) {
                $table->date('returned_at')->nullable()->after('due_date');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('borrowings', 'returned_at')) {
            Schema::table('borrowings', fn (Blueprint $table) => $table->dropColumn('returned_at'));
        }
    }
};
