# PHP_2023 Timerkhanov Artur hw15
## Архитектура кода

### Before
> Взял работу по Редису для рефакторинга, в проекте изначально не было четких слоев.<br>
[Проект по работе с Redis](https://github.com/otusteamedu/PHP_2023/tree/ATimerkhanov/hw12/code)<br>
> Все находилось хаотично - что можно увидеть на скрине

![alt text](img/before.png)

---
### After
> Архитектуру разбил на три слоя - Infrastructure, Application, Domain. <br>
> Добавил DTO для передачи данных между слоями, где смог добавил интерфейсы чтобы не зависить на прямую от класса. <br>
> В слое Domain добавил абстрактный класс - который позволяет не зависить от коткретного хранилища.<br>
> И в случае чего мы можем клепать любое кол-во разных хранилищ - у которых всегда будут нужные методы.
> 

![alt text](img/after.png)
