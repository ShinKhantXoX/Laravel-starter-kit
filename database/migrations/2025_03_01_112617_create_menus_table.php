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
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("menu_category_id");
            $table->foreign("menu_category_id")->references("id")->on("menu_categories");
            $table->string("name");
            $table->string("photo")->nullable()->default(null);
            $table->float("price", 10, 2);
            $table->string("description")->nullable();
            $table->string("status")->default(IsAvaliableStatusEnum::AVALIABLE->value);
            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
