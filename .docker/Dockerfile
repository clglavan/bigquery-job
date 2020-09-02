FROM php:7.4-fpm-alpine as BASE

ENV PROJECTID=0
ENV DATASETID=0
ENV GCSURI=0
ENV TABLEID=0

ENV GOOGLE_APPLICATION_CREDENTIALS=/key.json

COPY . /
WORKDIR /

RUN chmod a+r trigger.php

CMD [ "php", "./trigger.php" ]