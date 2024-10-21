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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('a_Id', 10)->comment('管理員帳號');
            $table->string('a_PassWord',200)->comment('管理員密碼');
            $table->string('a_Name', 10)->comment('管理員姓名');
            $table->string('a_Permissions', 50)->default('member_cru')->comment('管理員權限');
            $table->string('a_Level', 1)->default('1')->comment('管理員等級');
            $table->string('a_Mac', 30)->default('')->comment('管理員電腦')->nullable();
            $table->string('a_State', 1)->default('1')->comment('管理員狀態');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
