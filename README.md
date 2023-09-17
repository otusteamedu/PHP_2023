### Init Docker
```bash
cd app
docker-compose up --build -d
docker exec -it php-server bash
composer install
exit;
```

- Add **mysite.local** in /etc/hosts

### Test
```bash
curl -d "emails=123@mail.ru,123@yandex.ru" -X POST http://mysite.local
```
