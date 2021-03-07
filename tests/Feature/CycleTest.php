<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\User;
use App\Cycle;
use Storage;

class CycleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testCreateCycle()
    {
        $cycle = factory(Cycle::class)->create();
        $user = User::find($cycle->id);

        $response = $this->actingAs($user);

        $data = [
            'title' => $cycle->title,
            'content' => $cycle->content,
            'location' => $cycle->location,
            'area' => $cycle->area,
            'city' => $cycle->city,
            'lat' => $cycle->lat,
            'lng' => $cycle->lng,
        ];
        $response->post('/cycles',$data);
        $response->assertDatabaseHas('cycles', $data);
    }

    public function testDeleteCycle()
    {
        $cycle = factory(Cycle::class)->create();
        $user = User::find($cycle->user_id);

        $response = $this->actingAs($user);

        $data = [
            'title' => $cycle->title,
            'content' => $cycle->content,
            'location' => $cycle->location,
            'area' => $cycle->area,
            'city' => $cycle->city,
            'lat' => $cycle->lat,
            'lng' => $cycle->lng,
        ];

        $response->delete('/cycles/'.$cycle->id,$data);
        $response->assertDatabaseMissing('cycles', [
            'id' => $cycle->id,
        ]);
    }

    public function testDisplayCycles() 
    {   
        $cycle = factory(Cycle::class)->create();
        $user= User::find($cycle->user_id);

        $response = $this->actingAs($user);
        $data = [
            'title' => $cycle->title,
            'content' => $cycle->content,
            'location' => $cycle->location,
            'area' => $cycle->area,
            'city' => $cycle->city,
            'lat' => $cycle->lat,
            'lng' => $cycle->lng,
        ];
        $response->post('/cycles',$data);
        $response = $response->get('/users/'.$user->id);

        $response->assertSeeText($cycle->title);
    }

    public function testUpdateCycle()
    {
        $cycle = factory(Cycle::class)->create();
        $user = User::find($cycle->user_id);

        $response = $this->actingAs($user);

        $data = [
            'title' => $cycle->title,
            'content' => $cycle->content,
            'location' => $cycle->location,
            'area' => $cycle->area,
            'city' => $cycle->city,
            'lat' => $cycle->lat,
            'lng' => $cycle->lng,
        ];
        $response->post('/cycles/'.$cycle->id,$data);
        $response->assertDatabaseHas('cycles', $data);
    }
}

