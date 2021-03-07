<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Cycle;

class FavoriteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function testPostFavorite()
    {
        #いいねーテスト
        $user = factory(User::class)->create();
        $cycle = factory(Cycle::class)->create();

        $response = $this->actingAs($user);
        $response->post('/cycles/'.$cycle->id.'/favorite');
        $response->assertDatabaseHas('favorites', [
            'cycle_id' => $cycle->id,
        ]);

        $response->delete('/cycles/'.$cycle->id.'/unfavorite');
        $response->assertDatabaseMissing('favorites', [
            'cycle_id' => $cycle->id,
        ]);
    }

    public function testDisplayFavorites() 
    {   
        $user = factory(User::class)->create();
        $cycle = factory(Cycle::class)->create();

        $response = $this->actingAs($user);
        $response->post('/cycles/'.$cycle->id.'/favorite');

        $response = $response->get('/users/'.$user->id.'/favorites');

        $response->assertSeeText($cycle->title);
    }
}
