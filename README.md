### Инициализация проекта
1. Выполните 
```bash
    docker-compose up --build -d
    docker exec -it php-server bash 
    composer i
    exit;
```
2. Добавьте /etc/hosts -> mysite.local
3. Настроить БД
```bash
     docker exec -it db-server bash 
     mysql -uroot -p
```
  Выполнить запросы в файле /app/db/db.sql

---

### Описания 
- Реализация DataMapper. смтр (index.php)


