<?php

use App\Livewire\Backend\Auth\Logout;
use App\Models\User;
use Livewire\Livewire;

test('authenticated_user_can_logout', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user);

    $this->assertAuthenticated();

    Livewire::test(Logout::class)
        ->call('logout')
        ->assertRedirect(route('admin.login'));

    $this->assertGuest();
});

test('guest_cannot_call_logout_action', function () {
    Livewire::test(Logout::class)
        ->call('logout')
        ->assertRedirect(route('admin.login'));
});
