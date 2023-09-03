# Usage

Start application:

```shell
make up
```

Send POST htt request

```http request
POST /statement/generate
Content-Type: application/json

{
    "dateFrom": "2023-09-03 18:00:00",
    "dateTo": "2023-09-03 19:00:00"
}
```
