<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\IsAvaliableStatusEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("room_type_id");
            $table->foreign("room_type_id")->references("id")->on("room_types");
            $table->string('name');
            $table->string("room_number")->nullable()->default(null);
            $table->string("status")->nullable()->default(IsAvaliableStatusEnum::AVALIABLE->value);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
