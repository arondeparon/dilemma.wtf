<?php

use App\Http\Controllers\VoteController;
use App\Models\Decision;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('will return 404 if dilemma was not found', function () {
    $response = $this->postJson(action(VoteController::class, 'derp'), [
        'vote' => 'first',
    ]);

    $response->assertStatus(404);
});

it('will return 422 if vote is missing', function () {
    $dilemma = Decision::factory()->create();

    $response = $this->postJson(action(VoteController::class, $dilemma->hash));

    $response->assertStatus(422);
});

it('will return 422 if vote is invalid', function () {
    $dilemma = Decision::factory()->create();

    $response = $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => $dilemma->hash,
    ]);

    $response->assertStatus(422);
});

it('can vote for first dilemma', function () {
    $dilemma = Decision::factory()->create();

    $response = $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => 'first',
    ]);

    $response->assertNoContent();

    $this->assertDatabaseHas('decisions', [
        'id' => $dilemma->id,
        'first_dilemma_votes' => 1,
        'second_dilemma_votes' => 0,
    ]);
});

it('can vote for second dilemma', function () {
    $dilemma = Decision::factory()->create();

    $response = $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => 'second',
    ]);

    $response->assertNoContent();

    $this->assertDatabaseHas('decisions', [
        'id' => $dilemma->id,
        'second_dilemma_votes' => 1,
        'first_dilemma_votes' => 0,
    ]);
});

it('will decrement a previous vote if it is different from the current one', function () {
    $dilemma = Decision::factory()->create();

    $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => 'first',
    ]);

    $response = $this->postJson(action(VoteController::class, $dilemma->hash), [
        'vote' => 'second',
    ])->dump();

    $response->assertNoContent();

    $this->assertDatabaseHas('decisions', [
        'id' => $dilemma->id,
        'first_dilemma_votes' => 0,
        'second_dilemma_votes' => 1,
    ]);
});
