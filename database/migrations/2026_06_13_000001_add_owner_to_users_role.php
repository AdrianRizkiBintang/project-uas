<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: ubah enum supaya include 'owner'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('customer', 'karyawan', 'manager', 'owner') NOT NULL DEFAULT 'customer'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('customer', 'karyawan', 'manager') NOT NULL DEFAULT 'customer'");
    }
};