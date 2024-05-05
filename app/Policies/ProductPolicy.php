<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Checks if the user can update the product
     * @param User $user
     * @param Product $product
     * @return bool
     */

    public function update(User $user, Product $product): bool
    {
        return $product->article !== request()->article && $user->isAdmin() or
            $product->article === request()->article;
    }
}
