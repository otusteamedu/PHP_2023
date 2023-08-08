 Use command

#### `make setup`
    Start dockers

#### `make run-calc`
    Run positive case for calculator Sum

#### `make run-sort`
    Run result for task2 (take more popular 3 cities)

###### others

'make setup' - build and start docker, and set executable attributes

Some negative cases for calculator Sum
`make run-calc-error-case-01`
`make run-calc-error-case-02`
`make run-calc-error-case-03`
`make run-calc-error-case-04`

And some useful alias for docker-compose
```shell
dc-up-b:
docker-compose up --build

dc-up:
docker-compose up

dc-up-d:
docker-compose up -d

dc-down:
docker-compose down

dc-stop:
docker-compose stop
```
