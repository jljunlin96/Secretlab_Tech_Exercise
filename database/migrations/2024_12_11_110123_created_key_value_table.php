<?php

use App\Enums\DataTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('key_values', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->binary('value');
            $table->string('type')->default(DataTypes::String->value);
            $table->timestamps();

            $table->index('id');
            $table->index('key');
        });

        // To modify the column type to LONGBLOB
        DB::statement('ALTER TABLE key_values MODIFY `value` LONGBLOB');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('key_values');
    }
};
