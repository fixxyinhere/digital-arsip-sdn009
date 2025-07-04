<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_id')->unique()->nullable()->after('email');
            $table->string('phone')->nullable()->after('employee_id');
            $table->enum('position', ['operator', 'kepala_sekolah', 'guru'])->default('guru')->after('phone');
            $table->text('address')->nullable()->after('position');
            $table->string('avatar')->nullable()->after('address');
            $table->boolean('is_active')->default(true)->after('avatar');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'employee_id',
                'phone',
                'position',
                'address',
                'avatar',
                'is_active',
                'last_login_at'
            ]);
        });
    }
};
