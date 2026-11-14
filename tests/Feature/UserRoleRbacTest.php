<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRoleRbacTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $kasirUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->superAdmin = User::where('email', 'admin@azkamandiri.com')->first();
        $this->kasirUser = User::where('email', 'kasir@azkamandiri.com')->first();
    }

    public function test_super_admin_can_access_all_rbac_pages(): void
    {
        $role = Role::first();
        $user = User::first();

        $routes = [
            route('admin.users.index'),
            route('admin.users.create'),
            route('admin.users.edit', $user->id),
            route('admin.roles.index'),
            route('admin.roles.create'),
            route('admin.roles.edit', $role->id),
        ];

        foreach ($routes as $url) {
            $response = $this->actingAs($this->superAdmin)->get($url);
            $response->assertStatus(200);
        }
    }

    public function test_admin_can_create_and_update_user_with_role(): void
    {
        $roleKasir = Role::where('slug', 'kasir')->first();

        // 1. Create user
        $response = $this->actingAs($this->superAdmin)->post(route('admin.users.store'), [
            'name' => 'Ahmad Kasir Baru',
            'email' => 'ahmad.kasir@azkamandiri.com',
            'phone' => '081234567899',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => $roleKasir->id,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Ahmad Kasir Baru',
            'email' => 'ahmad.kasir@azkamandiri.com',
            'phone' => '081234567899',
            'is_active' => 1,
        ]);

        $createdUser = User::where('email', 'ahmad.kasir@azkamandiri.com')->first();
        $this->assertTrue($createdUser->hasRole('Kasir'));

        // 2. Update user
        $roleGudang = Role::where('slug', 'staff-gudang')->first();
        $updateResponse = $this->actingAs($this->superAdmin)->put(route('admin.users.update', $createdUser->id), [
            'name' => 'Ahmad Staff Gudang',
            'email' => 'ahmad.kasir@azkamandiri.com',
            'phone' => '081234567800',
            'role_id' => $roleGudang->id,
            'is_active' => '1',
        ]);

        $updateResponse->assertRedirect(route('admin.users.index'));
        $createdUser->refresh();
        $this->assertEquals('Ahmad Staff Gudang', $createdUser->name);
        $this->assertTrue($createdUser->hasRole('Staff Gudang'));
    }

    public function test_admin_can_toggle_user_active_status(): void
    {
        $this->assertTrue($this->kasirUser->is_active);

        // Deactivate
        $response = $this->actingAs($this->superAdmin)->patch(route('admin.users.toggle-status', $this->kasirUser->id));
        $response->assertRedirect();

        $this->kasirUser->refresh();
        $this->assertFalse($this->kasirUser->is_active);

        // Inactive user cannot log in
        $loginResponse = $this->post(route('admin.login.submit'), [
            'email' => 'kasir@azkamandiri.com',
            'password' => 'password',
        ]);

        $loginResponse->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_cannot_deactivate_or_delete_self(): void
    {
        // Attempt deactivate self
        $response = $this->actingAs($this->superAdmin)->patch(route('admin.users.toggle-status', $this->superAdmin->id));
        $response->assertSessionHas('error');
        $this->superAdmin->refresh();
        $this->assertTrue($this->superAdmin->is_active);

        // Attempt delete self
        $deleteResponse = $this->actingAs($this->superAdmin)->delete(route('admin.users.destroy', $this->superAdmin->id));
        $deleteResponse->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->superAdmin->id]);
    }

    public function test_admin_can_create_custom_role_with_permissions(): void
    {
        $permPos = Permission::where('name', 'pos.access')->first();
        $permReports = Permission::where('name', 'reports.sales')->first();

        $response = $this->actingAs($this->superAdmin)->post(route('admin.roles.store'), [
            'name' => 'Supervisor Kasir',
            'description' => 'Mengawasi kasir penjualan dan laporan harian',
            'permissions' => [$permPos->id, $permReports->id],
        ]);

        $response->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseHas('roles', [
            'name' => 'Supervisor Kasir',
            'slug' => 'supervisor-kasir',
        ]);

        $role = Role::where('slug', 'supervisor-kasir')->first();
        $this->assertTrue($role->hasPermission('pos.access'));
        $this->assertTrue($role->hasPermission('reports.sales'));
        $this->assertFalse($role->hasPermission('users.manage'));
    }

    public function test_permission_middleware_blocks_unauthorized_user(): void
    {
        // Kasir user has pos.access, but DOES NOT have users.manage or roles.manage
        $this->assertTrue($this->kasirUser->can('pos.access'));
        $this->assertFalse($this->kasirUser->can('users.manage'));

        // Kasir can access POS
        $posResponse = $this->actingAs($this->kasirUser)->get(route('admin.pos.index'));
        $posResponse->assertStatus(200);

        // Kasir CANNOT access User Management
        $userMgmtResponse = $this->actingAs($this->kasirUser)->get(route('admin.users.index'));
        $userMgmtResponse->assertRedirect(route('admin.dashboard'));
        $userMgmtResponse->assertSessionHas('error');

        // Kasir CANNOT access Roles Management
        $rolesResponse = $this->actingAs($this->kasirUser)->get(route('admin.roles.index'));
        $rolesResponse->assertRedirect(route('admin.dashboard'));
        $rolesResponse->assertSessionHas('error');
    }
}

