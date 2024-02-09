<?php

use Cases\Php2023\Domain\Pattern\Composite\OrderComposite;
use Cases\Php2023\Domain\Pattern\Factory\DishCreationStrategyFactory;
use Cases\Php2023\Presentation\Requests\RequestOrder;

$postCreateOrder = '{
  "order": [
    {
      "type": "burger",
      "quantity": 2,
      "addIngredients": ["салат", "помидор", "сыр чеддер"],
      "removeIngredients": []
    },
    {
      "type": "sandwich",
      "quantity": 1,
      "addIngredients": ["курица", "салат айсберг", "майонез"],
      "removeIngredients": []
    },
    {
      "type": "hotdog",
      "quantity": 1,
      "addIngredients": ["сосиска", "горчица", "кетчуп", "лук"],
      "removeIngredients": []
    },
    {
      "type": "burger",
      "quantity": 1,
      "addIngredients": [],
      "removeIngredients": ["горчица"]
    }
  ]
}';

$orders = json_decode($postCreateOrder, true);

foreach ($orders['order'] as $orderData) {
    $orderObjects[] = new RequestOrder(
        $orderData['type'],
        $orderData['quantity'],
        $orderData['addIngredients'],
        $orderData['removeIngredients']
    );
}

/**
 * Компоновщик
 */
$orderComposite = new OrderComposite();

foreach ($orderObjects as $order) {
    $strategy = DishCreationStrategyFactory::makeStrategy($order->type);
    $dish = $strategy->createDish($order);
    $orderComposite->addComponent($dish);
}

$names = $orderComposite->getNames();
echo $names;