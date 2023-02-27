# PHP_2023 HW8 - Console chat on Unix-sockets

How to Run:
1. Create `.env` from `.env.example`. Change `UNIX_SOCKET_DIR`
2. Create `unix_socket.ini` from `unix_socket.ini.example`
3. Run `make && make start`
4. Run `php src/app.php client` in any running client container and see opened server log.
5. You can disconnect from server with `Ctrl + C`, then check socket server log. 

> This docker-compose contain 1 socket server container and 3 socket clients (you can change replicas count)