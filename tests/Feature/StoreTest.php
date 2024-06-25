<?php

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Store;
use App\Models\Store as StoreModel;

test('stores page can be accessible', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get('/stores');

    $response->assertStatus(200);
});

test('store can be created', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Store::class)
        ->set('name', 'Test Store name')
        ->set('address', 'Manila, Philippines')
        ->call('store')
        ->assertRedirect(Store::class);

    $this->assertDatabaseHas('stores', [
        'name' => 'Test Store name',
        'address' => 'Manila, Philippines'
    ]);
});

test('store can be updated', function () {
    $user = User::factory()->create();
    $store = StoreModel::factory()->create([
        'user_id' => $user->id
    ]);
    
    Livewire::actingAs($user)
        ->test(Store::class)
        ->call('edit', $store->id)
        ->set('name', 'New Store name')
        ->set('address', 'Quezon City, Philippines')
        ->call('update')
        ->assertRedirect(Store::class);
    
    $this->assertDatabaseHas('stores', [
        'id' => $store->id,
        'name' => 'New Store name',
        'address' => 'Quezon City, Philippines',
    ]);
});


test('store can be deleted', function () {
    $user = User::factory()->create();
    $store = StoreModel::factory()->create([
        'user_id' => $user->id
    ]);

    Livewire::actingAs($user)
        ->test(Store::class)
        ->call('destroy', $store->id)
        ->assertRedirect(Store::class);

    $this->assertDatabaseHas('stores', [
        'id' => $store->id,
        'deleted_at' => now()
    ]);
});
