<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_guest_is_redirected_from_home_to_dashboard(): void
    {
        $this->get('/')->assertRedirect('/dashboard');
    }

    public function test_guest_cannot_see_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_logged_in_user_can_see_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Totale inkomsten');
    }
}