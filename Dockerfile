FROM ubuntu:latest
RUN apt-get update && apt-get install -y 

WORKDIR /files

CMD /bin/bash