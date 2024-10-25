<?php

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
        Schema::create('label', function (Blueprint $table) {
            $table->id();
            $table->string('l_Id', 10)->default('')->comment('編號')->nullable();
            $table->string('l_Title', 10)->default('')->comment('標題')->nullable();
            $table->string('l_TitleOne', 10)->default('')->comment('標籤1')->nullable();
            $table->string('l_TitleTwo', 10)->default('')->comment('標籤2')->nullable();
            $table->string('l_TitleThree', 10)->default('')->comment('標籤3')->nullable();
            $table->string('l_TitleFour', 10)->default('')->comment('標籤4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label');
    }
};
