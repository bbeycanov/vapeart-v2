<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Alkoqol satışı məhdudiyyəti üçün iki bayraq:
     *  - branches.sells_alcohol: bu filial alkoqol satır? (yalnız Gənclik = true)
     *  - categories.is_alcohol:  bu kateqoriya alkoqoldur? (Drinks/İçkilər = true)
     * Alkoqol kateqoriyasındakı məhsulun WhatsApp "al" düyməsində yalnız
     * alkoqol satan filiallar göstərilir.
     */
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->boolean('sells_alcohol')->default(false)->after('is_default');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_alcohol')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('sells_alcohol');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_alcohol');
        });
    }
};
