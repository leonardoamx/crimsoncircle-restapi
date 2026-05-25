<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ViewHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_view_history()
    {
        $this->getJson('/api/view-histories')->assertUnauthorized();
    }

    public function test_user_can_list_view_history()
    {
        $user = User::factory()->create();
        ViewHistory::factory()->count(3)->for($user)->create();

        $response = $this->actingAs($user)->getJson('/api/view-histories');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_user_can_create_view_history_entry()
    {
        $user = User::factory()->create();

        $payload = [
            'item_id' => 'ABC123',
        ];

        $response = $this->actingAs($user)->postJson('/api/view-histories', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.item_id', 'ABC123');

        $this->assertDatabaseHas('view_histories', [
            'item_id' => 'ABC123',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_view_single_view_history()
    {
        $user = User::factory()->create();
        $viewHistoryEntry = ViewHistory::factory()->for($user)->create();

        $response = $this->actingAs($user)->getJson("/api/view-histories/{$viewHistoryEntry->id}");

        $response->assertOk()
            ->assertJsonPath('data.id', $viewHistoryEntry->id);
    }

    public function test_only_owner_can_update_view_history()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $viewHistoryEntry = ViewHistory::factory()->for($owner)->create();

        // Forbidden for non-owner
        $this->actingAs($other)
            ->putJson("/api/view-histories/{$viewHistoryEntry->id}", ['item_id' => 'HACK'])
            ->assertForbidden();

        // Allowed for owner
        $this->actingAs($owner)
            ->putJson("/api/view-histories/{$viewHistoryEntry->id}", ['item_id' => 'UPD01'])
            ->assertOk()
            ->assertJsonPath('data.item_id', 'UPD01');
    }

    public function test_only_owner_can_delete_view_history()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $viewHistoryEntry = ViewHistory::factory()->for($owner)->create();

        // Forbidden for non-owner
        $this->actingAs($other)
            ->deleteJson("/api/view-histories/{$viewHistoryEntry->id}")
            ->assertForbidden();

        // Allowed for owner
        $this->actingAs($owner)
            ->deleteJson("/api/view-histories/{$viewHistoryEntry->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('view_histories', ['id' => $viewHistoryEntry->id]);
    }
}
