<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenancyTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create test organizations
        $org1 = Organization::create([
            'name' => 'Acme Corporation',
            'slug' => 'acme-corp',
            'description' => 'A test organization for tenancy testing',
            'type' => 'company',
            'email' => 'contact@acme.com',
            'status' => 'active',
        ]);

        $org2 = Organization::create([
            'name' => 'Tech Division',
            'slug' => 'tech-division',
            'description' => 'A test division for tenancy testing',
            'type' => 'division',
            'email' => 'info@techdiv.com',
            'status' => 'active',
        ]);

        // Create memberships
        $org1->users()->attach($user1, [
            'role' => 'admin',
            'is_primary' => true,
            'joined_at' => now(),
            'status' => 'active',
        ]);

        $org1->users()->attach($user2, [
            'role' => 'member',
            'is_primary' => false,
            'joined_at' => now(),
            'status' => 'active',
        ]);

        $org2->users()->attach($user2, [
            'role' => 'admin',
            'is_primary' => false,
            'joined_at' => now(),
            'status' => 'active',
        ]);

        $this->command->info('Test data created successfully!');
        $this->command->info('Users:');
        $this->command->info('- john@example.com (password: password)');
        $this->command->info('- jane@example.com (password: password)');
        $this->command->info('Organizations:');
        $this->command->info('- Acme Corporation (slug: acme-corp)');
        $this->command->info('- Tech Division (slug: tech-division)');
    }
}
