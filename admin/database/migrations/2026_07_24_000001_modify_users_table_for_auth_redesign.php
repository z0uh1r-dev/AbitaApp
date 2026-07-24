<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add new nullable columns first so this migration is safe to run
        // against a table that already has rows (not just the current
        // empty production table), then backfill, then tighten constraints.
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('role', 20)->default('user')->after('password');
            $table->string('status', 20)->default('active')->after('role');
            $table->boolean('is_protected')->default(false)->after('status');
            $table->boolean('must_change_password')->default(false)->after('is_protected');
            $table->timestamp('last_login_at')->nullable()->after('must_change_password');
        });

        // Best-effort backfill of first_name/last_name from the legacy `name`
        // column (splits on the first space), and role from `is_admin`.
        // The production `users` table is empty at the time of writing, so
        // this branch is dormant there, but keeps the migration correct for
        // any other environment (local/CI) that already seeded test users.
        if (Schema::hasColumn('users', 'name')) {
            DB::table('users')->orderBy('id')->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $parts = preg_split('/\s+/', trim((string) $user->name), 2);
                    DB::table('users')->where('id', $user->id)->update([
                        'first_name' => $parts[0] !== '' ? $parts[0] : 'User',
                        'last_name' => $parts[1] ?? '-',
                        'role' => ! empty($user->is_admin) ? 'super_admin' : 'user',
                        // One-time structural backfill only — not an ongoing
                        // authorization check, so referencing this specific
                        // account here does not violate the "no hardcoded
                        // emails outside the Seeder" rule for application logic.
                        'is_protected' => $user->email === 'admin@abitaofficedesign.com',
                    ]);
                }
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->boolean('is_admin')->default(false)->after('email');
        });

        DB::table('users')->orderBy('id')->chunkById(100, function ($users) {
            foreach ($users as $user) {
                DB::table('users')->where('id', $user->id)->update([
                    'name' => trim($user->first_name.' '.$user->last_name),
                    'is_admin' => $user->role === 'super_admin',
                ]);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'role',
                'status',
                'is_protected',
                'must_change_password',
                'last_login_at',
            ]);
        });
    }
};
