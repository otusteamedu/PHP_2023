Введение)

1. У меня на работе проект написан на Laravel
2. Мы используем библиотеку graphql для api

- Для того чтобы мне было понятно, как работать с DDD я поднял чистый laravel, поставил туда Rebing\GraphQL 
- Для понимания принципов DDD не отвлекаясь на сложную логику специально упростил задачу. 
- Задача: сохранить данные в БД, которые пришли.


Вот что получилось
1. Вызов старого и нового кода идет через файл app/config/graphql.php

```
    'mutation' => [
        'create_order' => CreateOrderMutation::class,
        'create_order_old' => OldCreateOrderMutation::class,
    ],
```

2. Как работает старый код.

Входная точка  App\OldCode\GraphQL\Mutations\OldCreateOrderMutation по сути является контроллером,
но, так как это graphql то мы должны описать
 - что к нам придет и какого это типа
 - что мы отдаем и какого это типа
 - правила валидации для данных


За логику отвечает класс CreateOrderService, так же в нем хранятся правила валидации в статическом методе на случай,
если они понадобятся еще где-то

```
class OldCreateOrderMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'create_order_old',
        'description' => 'Создание заявки старый код',
    ];

    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::string(),
                'description' => "Обязательный. email",
            ],
            'title' => [
                'type' => Type::string(),
                'description' => "Обязательный. Заголовок заявки",
            ],
            'description' => [
                'type' => Type::string(),
                'description' => "Обязательный. Описание заявки",
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return CreateOrderService::rules($args);
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $service = new CreateOrderService();
        return $service->run($args);
    }
}
```




```
use App\OldCode\Models\Order;
use Illuminate\Support\Arr;

class CreateOrderService
{
    public function run (array $args) : int
    {
         $order = new Order();
         $order->email = Arr::get($args, 'email');
         $order->title = Arr::get($args, 'title');
         $order->description = Arr::get($args, 'description');
         $order->save();

         return $order->id;
    }

    public static function rules(array $args = [])
    {
        return [
            'email' => ['required', 'string', 'email'],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
```

4. Новый код DDD

Входная точка App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrderService 

 1) что я сделал это код фреймворка в папке app перенес в app/Infrastructure
 2) создал папку app/Domains в нее будут добавляться модули
 3) создал папку app/Domains/Order - модуль для работы с Order
 4) в папке app/Domains/Order разложил код на 3 уровня

Далее я сделал DTO для передачи данных из мутации в CreateOrderUseCase,
Создал CreateOrderUseCase, добавил ValueObjects для описания полей сущности, написал интерфейс для взаимодействия
с БД, а реализацию положин на слой инфрастуктуры. Все сделал как на уроке.


5. Что я понял работая с DDD
 - Валидация на graphQl работает довольно хорошо. + хорошая обработка ошибок.
 - Отвалидированные данные, оборачиваюсят в DTO и отдаются на слой приложения. Тут мы полностью ушли от привязки к graphql.
Это хорошо. 
 - Возникает не то, что избыточная валидация, ее много не бывает, но довольно тяжело это все писать. Одно и тоже на разных слоях.
Думаю это дань стабильности, но скорость разработки падает довольно сильно.
 - Из-за того что в коде используется только 1 сущность, вроде все хорошо, но пока не знаю, что будет если
у order будет много связных данных, например user, company, depots, truck итд. При создании такой сущности приходит около
30 параметров, их нужно будет записывать в DTO потом каждое значение в VO. Нужно смотреть. В уроке не раскрыто это.
