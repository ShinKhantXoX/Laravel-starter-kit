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
        Schema::create('beds', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("room_id");
            $table->foreign("room_id")->references("id")->on("rooms");
            $table->string("label")->nullable();
            $table->string('bed_number')->nullable()->default(null);
            $table->string("remark")->nullable()->default(null);
            $table->string('status')->nullable()->default(IsAvaliableStatusEnum::AVALIABLE->value);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beds');
    }
};
