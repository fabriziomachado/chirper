<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

uses(RefreshDatabase::class);
beforeEach(function (): void {
    Artisan::call('migrate');
});

/**
 * A basic test example.
 */
// public function test_the_application_returns_a_successful_response(): void
// {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// }

it('can interact with the database in memory', function (): void {
    \App\Models\User::factory()->create(['name' => 'Fabrizio']);

    /** @var \Illuminate\Foundation\Testing\TestCase $this */
    $this->assertDatabaseHas('users', ['name' => 'Fabrizio']);
});
