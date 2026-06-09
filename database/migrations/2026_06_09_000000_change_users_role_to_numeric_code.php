<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'role')) {
            return;
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $column = DB::selectOne("SHOW COLUMNS FROM users WHERE Field = 'role'");

        if ($column && str_starts_with(strtolower($column->Type), 'tinyint')) {
            return;
        }

        DB::statement('ALTER TABLE users ADD COLUMN role_code TINYINT UNSIGNED NOT NULL DEFAULT 2 AFTER password');
        DB::statement("UPDATE users SET role_code = CASE role WHEN 'admin' THEN 1 WHEN 'siswa' THEN 2 WHEN 'tutor' THEN 3 ELSE 2 END");
        DB::statement('ALTER TABLE users DROP COLUMN role');
        DB::statement("ALTER TABLE users CHANGE role_code role TINYINT UNSIGNED NOT NULL DEFAULT 2 COMMENT '1=admin, 2=siswa, 3=tutor'");
    }

    public function down(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'role')) {
            return;
        }

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $column = DB::selectOne("SHOW COLUMNS FROM users WHERE Field = 'role'");

        if ($column && str_starts_with(strtolower($column->Type), 'enum')) {
            return;
        }

        DB::statement("ALTER TABLE users ADD COLUMN role_name ENUM('admin', 'tutor', 'siswa') NOT NULL DEFAULT 'siswa' AFTER password");
        DB::statement("UPDATE users SET role_name = CASE role WHEN 1 THEN 'admin' WHEN 3 THEN 'tutor' ELSE 'siswa' END");
        DB::statement('ALTER TABLE users DROP COLUMN role');
        DB::statement("ALTER TABLE users CHANGE role_name role ENUM('admin', 'tutor', 'siswa') NOT NULL DEFAULT 'siswa'");
    }
};
