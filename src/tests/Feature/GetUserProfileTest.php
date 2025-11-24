<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GetUserProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // 必要な情報が表示される
    public function test_view_user_data()
    {
        $user = \App\Models\User::factory()->create();

        $account = \App\Models\Account::factory()->create([
            'user_id' => $user->id,
            'name' => '山田太郎',
            'image' => 'test.png'
        ]);

        $this->actingAs($user);

        $item = \App\Models\Item::factory()->create();

        $response = $this->get('/purchase/' . $item->id);
        $response->assertStatus(200);

        $response = $this->post('/order', [
            'item_id' => $item->id,
            'account_id' => $account->id,
            'method' => 1,
            'post_code' => 123-4567,
            'address' => 'テスト'
        ]);

        $response = $this->get('/sell');
        $response->assertStatus(200);

        $file = UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg');

        $response = $this->post('/listing', [
            'image'       => $file,
            'condition'   => 1,
            'name'        => 'テスト',
            'brand'       => 'テストブランド',
            'description' => 'これはテストです',
            'price'       => 100000,
            'category_id' => 1,
        ]);

        $response = $this->get('/mypage/profile');
        $response->assertStatus(200);

        $response->assertSee('/storage/' . $account->image);
        $response->assertSee('山田太郎');

        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);

        $response->assertSee($item->name);

        $response = $this->get('/mypage?page=sell');
        $response->assertStatus(200);

        $response->assertSee('テスト');
    }
}
