<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSuperAdmin();
        $this->seedExemptEmployee('f.zohair@abitaofficedesign.com', 'Zohair', 'Fekkak', 'EMPLOYEE_ZOHAIR_INITIAL_PASSWORD');
        $this->seedExemptEmployee('f.hachem@abitaofficedesign.com', 'Hachem', 'Fekkak', 'EMPLOYEE_HACHEM_INITIAL_PASSWORD');
    }

    /**
     * The owner account. Full permissions, immune to delete/suspend/role
     * change via `is_protected` — never via a hardcoded email check
     * anywhere else in the application.
     */
    private function seedSuperAdmin(): void
    {
        $email = 'admin@abitaofficedesign.com';

        if (User::where('email', $email)->exists()) {
            $this->command->info("Super Administrator {$email} already exists — reusing it, no changes made.");

            return;
        }

        $password = env('SUPER_ADMIN_INITIAL_PASSWORD') ?? Str::password(16);

        $user = new User([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => $email,
            'password' => $password,
            'role' => UserRole::SuperAdmin,
            'status' => UserStatus::Active,
            'must_change_password' => false,
        ]);
        // is_protected is intentionally excluded from $fillable — this is
        // the one place in the whole application allowed to set it.
        $user->is_protected = true;
        $user->save();

        $this->printCredential("Created Super Administrator {$email} with password: {$password}");
    }

    /**
     * Trusted internal accounts exempt from the onboarding workflow: keep
     * the admin-configured password, no forced change on first login, no
     * welcome email. They still authenticate via the full email+password+OTP
     * flow like everyone else.
     */
    private function seedExemptEmployee(string $email, string $firstName, string $lastName, string $envKey): void
    {
        if (User::where('email', $email)->exists()) {
            $this->command->info("User {$email} already exists — reusing it, no changes made.");

            return;
        }

        $password = env($envKey) ?? Str::password(16);

        User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
            'role' => UserRole::User,
            'status' => UserStatus::Active,
            'must_change_password' => false,
        ]);

        $this->printCredential("Created {$email} with password: {$password}");
    }

    /**
     * Generated passwords can contain characters like < > & that Symfony
     * Console's tag-based output formatter would otherwise misinterpret as
     * markup, corrupting what's printed. OUTPUT_RAW disables all tag
     * parsing so the message (and the password inside it) prints verbatim.
     */
    private function printCredential(string $message): void
    {
        $this->command->getOutput()->writeln($message, OutputInterface::OUTPUT_RAW);
    }
}
