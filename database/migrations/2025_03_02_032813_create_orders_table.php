<?php

use App\Enums\{
    PaymentTypeEnum,
    GeneralStatusEnum
};
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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("bed_id");
            $table->uuid("room_id");
            $table->float("total_amount", 9,2);
            $table->float("pay_amount", 9,2);
            $table->float("refund_amount", 9,2);
            $table->string("remark")->nullable()->default(null);
            $table->string("payment_type")->default(PaymentTypeEnum::CASH->value);
            $table->string("status")->default(GeneralStatusEnum::ACTIVE->value);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
