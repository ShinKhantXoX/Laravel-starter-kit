<?php

use App\Enums\OrderItemStatusEnum;
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
        Schema::create('order_lists', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("order_id");
            $table->uuid("menu_id");
            $table->string("name")->unique();
            $table->float("price", 9, 2);
            $table->integer("quantity");
            $table->float("amount", 9,2);
            $table->string("status")->default(OrderItemStatusEnum::CONFIRM->value);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lists');
    }
};
