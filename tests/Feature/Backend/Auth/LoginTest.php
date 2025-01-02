<?php

use App\Livewire\Backend\Auth\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Livewire\Livewire;

pest()->group('auth');

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
    ]);
});

it('render_login_successfully', function () {
    Livewire::test(Login::class)->assertStatus(200);
});

it('component_exists_on_the_page', function () {
    $this->get('/admin/login')
        ->assertSeeLivewire(Login::class)
        ->assertSee('Admin | Login');
});

it('shows_validation_errors_when_fields_are_empty', function () {
    Livewire::test(Login::class)
        ->call('postLogin')
        ->assertHasErrors(['email' => 'required', 'password' => 'required']);
});

it('shows_validation_errors_for_invalid_email', function () {
    Livewire::test(Login::class)
        ->set('email', 'invalid-email')
        ->set('password', 'password')
        ->call('postLogin')
        ->assertHasErrors(['email' => 'email']);
});

it('authenticates_user_with_valid_credentials', function () {
    Livewire::test(Login::class)
        ->set('email', 'admin@example.com')
        ->set('password', 'password')
        ->set('rememberMe', true)
        ->call('postLogin')
        ->assertRedirect(route('admin.dashboard'));

    // Assert the user is authenticated
    $this->assertAuthenticatedAs($this->user);
});

it('shows_error_for_invalid_credentials', function () {
    Livewire::test(Login::class)
        ->set('email', 'admin@example.com')
        ->set('password', 'wrongpassword')
        ->call('postLogin')
        ->assertHasErrors()
        ->assertSee('Invalid email or password.');

    // Assert the user is not authenticated
    $this->assertGuest();
});

it('admin_guest_middleware_redirects_authenticated_users', function () {
    // Simulate an authenticated user
    Auth::login($this->user);

    $this->get('/admin/login')
        ->assertRedirect(route('admin.dashboard'));
});

it('admin_guest_middleware_allows_guest_access', function () {
    $this->get('/admin/login')
        ->assertOk();
});
