<?php

use App\Enums\UserRole;
use App\Livewire\Backend\Dashboard;
use App\Models\User;
use Livewire\Livewire;

pest()->group('dashboard');

it('middleware_allows_access_for_correct_role', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/dashboard')
        ->assertOk();
});

it('middleware_denies_access_for_incorrect_role', function () {
    $user = User::factory()->create(['role' => UserRole::User]);

    $this->actingAs($user)
        ->get('/admin/dashboard')
        ->assertRedirect();
});

it('render_Dashboard_successfully', function () {
    Livewire::test(Dashboard::class)->assertStatus(200);
});
