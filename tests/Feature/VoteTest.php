<?php

use App\Http\Controllers\VoteController;
use App\Models\Dilemma;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('will return 404 if dilemma was not found', function () {
    $response = $this->postJson(action(VoteController::class, 'derp'), [
        'vote' => 'first',
    ]);

    $response->assertStatus(404);
});

it('will return 422 if vote is missing', function () {
    $dilemma = Dilemma::factory()->create();

    $response = $this->postJson(action(VoteController::class, $dilemma->hash));

    $response->assertStatus(422);
});

it('will return 422 if vote is invalid', function () {
    $dilemma = Dilemma::factory()->create();

    $response = $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => $dilemma->hash,
    ]);

    $response->assertStatus(422);
});

it('can vote for first dilemma', function () {
    $dilemma = Dilemma::factory()->create();

    $response = $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => 'first',
    ]);

    $response->assertNoContent();

    $this->assertDatabaseHas('dilemmas', [
        'id' => $dilemma->id,
        'first_dilemma_votes' => 1,
        'second_dilemma_votes' => 0,
    ]);
});

it('can vote for second dilemma', function () {
    $dilemma = Dilemma::factory()->create();

    $response = $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => 'second',
    ]);

    $response->assertNoContent();

    $this->assertDatabaseHas('dilemmas', [
        'id' => $dilemma->id,
        'second_dilemma_votes' => 1,
        'first_dilemma_votes' => 0,
    ]);
});

it('will return 429 if voting too fast', function () {
    $dilemma = Dilemma::factory()->create();

    $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => 'first',
    ]);

    $response = $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => 'second',
    ]);

    $this->assertDatabaseHas('dilemmas', [
        'id' => $dilemma->id,
        'first_dilemma_votes' => 1,
        'second_dilemma_votes' => 0,
    ]);

    $response->assertStatus(429);
});
