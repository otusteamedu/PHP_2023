
# PHP Unix Socket Communication

This project contains two PHP processes that communicate with each other using Unix sockets:
1) `client`
2) `server`

## Overview

The `client` sends messages to the `server` via a Unix socket. The `server` listens for incoming messages on the Unix socket, processes them, and sends back a confirmation. This setup allows for inter-process communication (IPC) within the same machine or across containers when the socket file is shared through a volume.

## Setup

The project uses Docker containers to run the PHP processes. Each process runs in its own container, with the Unix socket file shared between them using a Docker volume.

## Running the Processes

To interact with the processes, you need to access the console output of each container. This is done by entering the containers and running the PHP scripts located at `/usr/src/myapp/`.

### Server Process

To start the `server` process, follow these steps:

1. Enter the container running the server PHP process:
   ```
   docker exec -it <server-container-name> /bin/bash
   ```
2. Navigate to the script location:
   ```
   cd /usr/src/myapp/
   ```
3. Run the server script:
   ```
   php server.php
   ```

The server will now be listening for messages sent to the Unix socket.

### Client Process

To send messages from the `client`, follow these steps:

1. Enter the container running the client PHP process:
   ```
   docker exec -it <client-container-name> /bin/bash
   ```
2. Navigate to the script location:
   ```
   cd /usr/src/myapp/
   ```
3. Run the client script:
   ```
   php client.php
   ```

Follow the prompts in the client's console to send messages to the server.

## Communication

The client and server communicate through a Unix socket located at `/tmp/unix.sock`. The socket file is created by the server process and is used by the client process to send messages to the server.

## Note

If you receive a "Broken pipe" error on the client side, it may be because the server has closed the connection. Ensure the server is running and listening for new messages before starting the client.

Make sure to stop the server process properly to clean up the socket file. If the socket file is not removed, it could prevent the server from starting up again.
