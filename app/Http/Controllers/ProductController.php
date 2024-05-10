<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductFormRequest;
use App\Http\Requests\UpdateProductFormRequest;
use App\Models\Product;
use App\Models\Status;
use App\Notifications\ProductCreated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index($available = null): Response
    {
        $product = Product::query();
        if ($available) {
            // Filters the products list
            $product = $product->available();
        }

        $product = $product->latest()->paginate(config('products.paginate_count'));

        return Inertia::render('Main', [
            'products' => $product,
            'statuses' => Status::all(),
        ]);
    }

    public function store(CreateProductFormRequest $request): RedirectResponse
    {
        $params = $request->validated();
        $product = Product::create($params);

        // Sends Notifications about the new product
        Notification::route('mail', config('products.email'))->notify(new ProductCreated($product));

        return to_route('products.all', [], 303);
    }

    public function update(UpdateProductFormRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        // checks if the auth user tries to update the article and if user's role is admin to do that
        if (!$request->user()->can('update', $product)) {
            return to_route('products.all')->withErrors(['article' => 'Только администратор может менять артикул!']);
        };

        $product->update($data);

        return to_route('products.all', [], 303);
    }

    public function delete(Product $product): RedirectResponse
    {
        $product->delete();

        return to_route('products.all', [], 303);
    }
}
