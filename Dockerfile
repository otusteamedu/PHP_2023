FROM ubuntu:latest
RUN apt-get update

WORKDIR /files

CMD /bin/bash