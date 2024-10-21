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
        Schema::create('member', function (Blueprint $table) {
            $table->id();
            $table->string('m_Id', 10)->comment('會員編號');
            $table->string('m_CardId', 10)->comment('會員身分證號');
            $table->string('m_Name', 20)->comment('會員姓名');
            $table->string('m_Birthday', 10)->default('')->comment('會員生日')->nullable();
            $table->string('m_Address', 50)->default('')->comment('會員地址')->nullable();
            $table->string('m_Email', 30)->default('')->comment('會員信箱')->nullable();
            $table->string('m_Phone', 20)->default('')->comment('會員電話')->nullable();
            $table->longText('m_Img')->comment('會員照片')->nullable();
            $table->string('m_Remark', 200)->default('')->comment('會員備註')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
