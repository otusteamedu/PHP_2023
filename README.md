Текст домашнего задания

Разрабатываем часть интернет-ресторана. Продаёт он фаст-фуд.
1. Фабричный метод будет отвечать за генерацию базового продукта-прототипа: бургер, сэндвич или хот-дог
2. При готовке каждого типа продукта Фабричный метод будет добавлять составляющие к базовому продукту либо по рецепту, либо по пожеланию клиента (салат, лук, перец и т.д.)
3. Цепочка обязанностей подписывается на статус приготовления и отправляет оповещения о том, что изменился статус приготовления продукта.
4. Стратегия будет отвечать за готовку продукта
5. Абстрактная фабрика будет генерировать заказы с сайта, из магазина и через телефон.
6. Все сущности должны по максимуму генерироваться через DI.

<hr>

1. У меня на работе проект написан на Laravel
2. Мы используем библиотеку graphql для api

- Для того чтобы мне было понятно, как работать с DDD я поднял чистый laravel, поставил туда Rebing\GraphQL

<hr>

## Описание по пунктам ДЗ

1. класс App\Domains\Order\Domain\Factories\Product\ProductFactory
2. класс App\Domains\Order\Domain\Factories\Product\ProductFactory метод addIngredientsToProduct()
3. классы 
    - создание цепочки -  App\Domains\Order\Domain\Subscribers\SendNotificationsService
    - изменения статуса тут App\Domains\Order\Application\CockProductProcessUseCase
    - запуск цепочки тут App\Domains\Order\Application\CockProductProcessUseCase ($this->publisher->notify($product);)
    - подписание в сервис провайдере App\Infrastructure\Providers\AppServiceProvider

```
    private function registerPublishers(): void
    {
        $this->app->bind(PublisherProductChangeStatusInterface::class, function ($app) {
           $publisher = new PublisherProductChangeStatus();
           $publisher->subscribe(new SendNotificationsService());
        });
    }
```
   
4. классы 
      - стратения 1 App\Domains\Order\Domain\Strategies\Cock\FryingPanCockStrategy
      - стратения 2 App\Domains\Order\Domain\Strategies\Cock\GrillCockStrategy
      - выбор стратегии повесил в сервис провайдер App\Infrastructure\Providers\AppServiceProvider
 

   ```
private function registerStrategies(): void
{
     $this->app->singleton(CockStrategyInterface::class, GrillCockStrategy::class);
}
   ```

5. Создал 3 разных запроса api имитирующий создание заказа с разных мест. 
    - app/Domains/Order/Infrastructure/GraphQL/Mutations/CreateOrder/CreateOrderFromPhoneMutation.php
    - app/Domains/Order/Infrastructure/GraphQL/Mutations/CreateOrder/CreateOrderFromShopMutation.php
    - app/Domains/Order/Infrastructure/GraphQL/Mutations/CreateOrder/CreateOrderFromSiteMutation.php

 в App\Domains\Order\Application\CreateOrderUseCase метод run они передают нужную абстрактную фабрику
 - App\Domains\Order\Domain\Factories\Order\OrderPhoneFactory
 - App\Domains\Order\Domain\Factories\Order\OrderShopFactory
 - App\Domains\Order\Domain\Factories\Order\OrderSiteFactory
