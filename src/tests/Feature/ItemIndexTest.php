<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_view_index_all_item()
    {
        $items = \App\Models\Item::factory()->count(3)->create();

        $response = $this->get('/');
        $response->assertStatus(200);

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_view_index_sold_label()
    {
        $item = \App\Models\Item::factory()->create();

        $orders = \App\Models\Order::factory()->create([
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);

        foreach ($orders as $order) {
            $response->assertSee('SOLD');
        }
    }

    public function test_hide_item_sell_user()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('test12345'),
            ]);

        $account = \App\Models\Account::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $myItem = \App\Models\Item::factory()->create([
            'account_id' => $account->id,
            'name' => 'test_item',
        ]);

        $response = $this->get('/');
    $response->assertStatus(200);

    // 自分の商品は非表示になる
    $response->assertDontSee('test_item');
    }
}
