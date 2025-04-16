<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\{
    LadyTypeEnum,
    IsAvaliableStatusEnum
};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ladies', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('profile')->nullable()->default(null);
            $table->string('name');
            $table->string('serial_number')->unique()->nullable();
            $table->string('phone_number')->unique();
            $table->string('nrc')->unique();
            $table->string('nrc_back')->nullable()->default(null);
            $table->string('nrc_front')->nullable()->default(null);
            $table->date('dob');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('address');
            $table->datetime('join_date');
            $table->datetime('leave_date');
            $table->string('remark')->nullable();
            $table->string('lady_type')->default(LadyTypeEnum::NORMAL->value);
            $table->string('status')->default(IsAvaliableStatusEnum::AVALIABLE->value);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ladies');
    }
};
