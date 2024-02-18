<?php

namespace App\Domains\Order\Domain\Factories;

use App\Domains\Order\Application\Requests\AddProductToOrderRequest;
use App\Domains\Order\Domain\Entity\Product\AbstractProduct;
use App\Domains\Order\Domain\Entity\Product\ProductBurger;
use App\Domains\Order\Domain\Entity\Product\ProductHotDog;
use App\Domains\Order\Domain\Entity\Product\ProductSandwich;
use App\Domains\Order\Domain\Exeptions\NoValidIngredientException;

class ProductFactory extends AbstractProductFactory
{
    private array $availableProducts = [
        'burger' => ProductBurger::class,
        'hot-dog' => ProductHotDog::class,
        'sandwich' => ProductSandwich::class,
    ];

    public function make(AddProductToOrderRequest $request): AbstractProduct
    {
        $product = $this->generateProduct($request->productTypeName);
        $product = $this->addIngredientsToProduct($product, $request->additionalIngredients);
        return $product;

    }

    private function generateProduct(string $productTypeName): AbstractProduct
    {
        $className = $this->availableProducts[$productTypeName] ?? null;
        if (!$className) {
            throw new \InvalidArgumentException('Тип продукта неверный');
        }

        return new $className();
    }

    /**
     * @throws NoValidIngredientException
     */
    private function addIngredientsToProduct(AbstractProduct $product, array $additionalIngredients): AbstractProduct
    {
        $availableAdditionalIngredientsOfProduct = $this->repository->getAvailableAdditionalIngredientsOfProduct($product);
        $defaultIngredientsOfProduct = $this->repository->getDefaultIngredientsOfProduct($product);


        $product->addDefaultIngredients($defaultIngredientsOfProduct);

        foreach ($additionalIngredients as $ingredient) {
            if (!in_array($ingredient->name, $availableAdditionalIngredientsOfProduct)) {
                throw new NoValidIngredientException('Ошика добавления доп ингредиента');
            }
            $product->addAdditionalIngredient($ingredient);
        }
        return $product;
    }
}
