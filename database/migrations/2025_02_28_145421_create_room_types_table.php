<?php

use App\Enums\IsAvaliableStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("label");
            $table->string("description")->nullable()->default(null);
            $table->string("status")->nullable()->default(IsAvaliableStatusEnum::AVALIABLE->value);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('room_types', function (Blueprint $table) {
        //     if (Schema::hasColumn('room_types', 'deleted_at')) {
        //         $table->dropSoftDeletes(); // Remove the column only if it exists
        //     }
        // });
        Schema::dropIfExists('room_types');
    }

};
