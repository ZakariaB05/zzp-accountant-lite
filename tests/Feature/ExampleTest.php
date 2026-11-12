    public function test_logged_in_user_can_see_dashboard(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Totale inkomsten');
    }