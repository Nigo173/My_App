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
        Schema::create('trade', function (Blueprint $table) {
            $table->id();
            $table->string('t_Id', 25)->comment('交易編號');
            $table->string('t_No', 25)->comment('交易標籤流水號');
            $table->string('t_aId', 10)->comment('管理員編號');
            $table->string('t_aName', 10)->comment('管理員姓名');
            $table->string('t_lId', 20)->comment('標籤編號');
            $table->string('t_lTitle', 10)->comment('交易分類');
            $table->string('t_mId', 10)->comment('會員編號');
            $table->string('t_mCardId', 10)->comment('會員身分證');
            $table->string('t_mName', 10)->comment('會員姓名');
            $table->string('t_mBirthday', 10)->comment('會員生日');
            $table->string('t_mPhone', 20)->comment('會員電話');
            $table->longText('t_mImg')->comment('會員照片');

            // $table->string('t_Title', 15)->comment('交易名稱');
            // $table->string('t_Content', 100)->comment('交易內容')->nullable();
            // $table->string('t_Money', 10)->comment('交易金額');
            // $table->string('t_PayDateTime', 10)->comment('交易時間');
            // $table->string('t_Remark', 200)->comment('交易備註')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade');
    }
};
