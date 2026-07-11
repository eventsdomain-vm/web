<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // =====================================================================
        // Permissions
        // =====================================================================
        $permissions = [
            // Event permissions
            'create-events',
            'edit-events',
            'delete-events',
            'publish-events',
            'approve-events',
            'reject-events',

            // Sponsorship permissions
            'manage-packages',
            'manage-sponsors',
            'manage-sponsorships',

            // Partner permissions
            'manage-partners',
            'manage-services',
            'bid-opportunities',
            'verify-partners',

            // Analytics
            'view-analytics',
            'view-reports',

            // Admin permissions
            'manage-users',
            'verify-users',
            'ban-users',
            'manage-categories',
            'manage-cms',
            'manage-roles',
            'manage-settings',
            'view-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Clear the permission cache after creating all permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // =====================================================================
        // Roles
        // =====================================================================

        // Organizer role
        $organizer = Role::create(['name' => 'organizer']);
        $organizer->permissions()->attach(
            Permission::whereIn('name', [
                'create-events',
                'edit-events',
                'delete-events',
                'publish-events',
                'manage-packages',
                'manage-sponsors',
                'manage-partners',
                'view-analytics',
            ])->pluck('id')
        );

        // Sponsor role
        $sponsor = Role::create(['name' => 'sponsor']);
        $sponsor->permissions()->attach(
            Permission::whereIn('name', ['view-analytics'])->pluck('id')
        );

        // Partner role
        $partner = Role::create(['name' => 'partner']);
        $partner->permissions()->attach(
            Permission::whereIn('name', [
                'manage-services',
                'bid-opportunities',
                'view-analytics',
            ])->pluck('id')
        );

        // Admin role — full access
        $admin = Role::create(['name' => 'admin']);
        $admin->permissions()->attach(Permission::pluck('id'));
    }
}
