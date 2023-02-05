<?php

namespace Tests\Feature;

use App\Models\Apartment;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApartmentUserTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
    public function test_user_seen_apartment()
    {
        $this->actingAs($this->user);
        $apartment = Apartment::factory()->create();

        $response = $this->post('/api/apartments/' . $apartment->id . '/seen');
        $this->user->refresh();

        $response->assertStatus(200);
        $this->assertDatabaseHas('apartment_user', [
            'user_id' => $this->user->id,
            'apartment_id' => $apartment->id,
        ]);
        $this->assertTrue($this->user->seenApartments->contains($apartment));
    }

    public function test_user_favorite_seen_apartment()
    {
        $this->actingAs($this->user);
        $apartment = Apartment::factory()
            ->hasAttached($this->user, ['is_favorite' => false], 'seenByUsers')
            ->create();

        $response = $this->post(route('apartments.favorite', $apartment));
        $this->user->refresh();

        $response->assertStatus(200);
        $this->assertDatabaseHas('apartment_user', [
            'user_id' => $this->user->id,
            'apartment_id' => $apartment->id,
            'is_favorite' => true,
        ]);
        $this->assertTrue($this->user->seenApartments->contains($apartment));
        $this->assertTrue($this->user->favoriteApartments->contains($apartment));
    }

    public function test_user_unfavorite_seen_apartment()
    {
        $this->actingAs($this->user);
        $apartment = Apartment::factory()
            ->hasAttached($this->user, ['is_favorite' => true], 'seenByUsers')
            ->create();

        $response = $this->post(route('apartments.favorite', $apartment));
        $this->user->refresh();

        $response->assertStatus(200);
        $this->assertDatabaseHas('apartment_user', [
            'user_id' => $this->user->id,
            'apartment_id' => $apartment->id,
            'is_favorite' => false,
        ]);
        $this->assertTrue($this->user->seenApartments->contains($apartment));
        $this->assertTrue(!$this->user->favoriteApartments->contains($apartment));
    }

    public function test_user_unseen_favorite()
    {
        $this->actingAs($this->user);
        $apartment = Apartment::factory()->create();

        $response = $this->post(route('apartments.favorite', $apartment));
        $this->user->refresh();

        $response->assertStatus(200);
        $this->assertDatabaseHas('apartment_user', [
            'user_id' => $this->user->id,
            'apartment_id' => $apartment->id,
            'is_favorite' => true,
        ]);
        $this->assertTrue($this->user->seenApartments->contains($apartment));
        $this->assertTrue($this->user->favoriteApartments->contains($apartment));
    }
}
