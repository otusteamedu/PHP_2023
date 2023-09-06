### Init Docker
```bash
- cd app
- cd config && cp config.ini.example.php config.ini.php
- cd ../
- docker-compose up --build -d
- docker exec -it php-server bash
- composer install
- exit;
```

### Test
#### Start Server
```bash
- docker exec -it php-server bash
- cd public
- php app.php server
```

#### Start Client 
```bash
- docker exec -it php-client bash
- cd public
- php app.php client 
```