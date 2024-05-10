<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use App\Notifications\ProductCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User can create a product
     */
    public function test_user_can_create_product(): void
    {
        $user = User::factory()->create();
        $status = Status::factory()->available()->create();
        $product = Product::factory()->make(['status_id' => $status->id])->toArray();

        $response = $this->actingAs($user)->post(route('products.add'), $product);

        $response->assertRedirect(route('products.all'));

        $this->assertDatabaseHas('products', [
            'article' => $product['article'],
            'name' => $product['name'],
            'status_id'=> $product['status_id'],
            ]
        );
    }

    /**
     * Admin can change an article label
     */
    public function test_admin_can_change_article(): void
    {
        $user = User::factory()->admin()->create();
        $status = Status::factory()->available()->create();

        $product = Product::factory()->create(['status_id' => $status->id]);

        $response = $this->actingAs($user)->patch(route('products.update', $product), [
            'article' => 'test001',
            'name' => $product->name,
            'status_id' => $product->status_id,
        ]);

        $response->assertRedirect(route('products.all'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'article' => 'test001',
            'name' => $product->name,
            'status_id' => $product->status_id,
            ]);
    }

    /**
     * User that is not admin can't change product's article
     */

    public function test_user_not_admin_cant_change_article(): void
    {
        $user = User::factory()->create();
        $status = Status::factory()->available()->create();

        $product = Product::factory()->create(['status_id' => $status->id]);

        $response = $this->actingAs($user)->patch(route('products.update', $product), [
            'article' => 'test002',
            'name' => $product->name,
            'status_id' => $product->status_id,
        ]);

        $response->assertInvalid('article');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'article' => $product->article,
            'name' => $product->name,
            'status_id' => $product->status_id,
            ]);
    }

    /**
     * User can update products data except for article
     */
    public function test_user_can_update_product(): void
    {
        $user = User::factory()->create();
        $status = Status::factory()->available()->create();

        $product = Product::factory()->create(['status_id' => $status->id]);

        $unavailable_status = Status::factory()->unavailable()->create();
        $new_product = Product::factory()->make(['status_id' => $unavailable_status->id]);

        $response = $this->actingAs($user)->patch(route('products.update', $product), [
            'article' => $product->article,
            'name' => $new_product->name,
            'status_id' => $new_product->status_id,
        ]);

        $response->assertRedirect(route('products.all'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'article' => $product->article,
            'name' => $new_product->name,
            'status_id' => $new_product->status_id,
        ]);
    }

    /**
     * User can delete a product, and it will be soft deleted
     */
    public function test_user_can_delete_product(): void {
        $user = User::factory()->create();
        $status = Status::factory()->available()->create();

        $product = Product::factory()->create(['status_id' => $status->id]);

        $this->actingAs($user)->delete(route('products.delete', $product));

        $this->assertSoftDeleted($product);
    }

    /**
     * Notification is sent when a product created
     */
    public function test_notification_sent(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $status = Status::factory()->available()->create();
        $product = Product::factory()->make(['status_id' => $status->id])->toArray();

        $this->actingAs($user)->post(route('products.add'), $product);

        Notification::assertSentOnDemand(ProductCreated::class);
    }
}
