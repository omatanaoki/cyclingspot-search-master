<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Cycling;

class CyclingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testCreateCycling()
    {
        $cycling = factory(Cycling::class)->create();
        $user = User::find($cycling->user_id);

        $response = $this->actingAs($user);

        $data = [
            'comment' => $cycling->comment,
        ];

        $response->post('/cyclings',$data);
        $response->assertDatabaseHas('cyclings',$data);
    }

    public function testDeleteCycling()
    {
        $cycling = factory(Cycling::class)->create();
        $user = User::find($cycling->user_id);

        $response = $this->actingAs($user);

        $data = [
            'comment' => $cycling->comment,
        ];

        $response->delete('/cyclings/'.$cyclng->id,$data);
        $response->assertDatabaseMissing('cyclings', [
            'id' => $cycling->id,
        ]);
    }
}