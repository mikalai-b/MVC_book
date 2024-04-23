FROM alpine:latest

RUN apk --no-cache add sqlite

COPY initial-db.sqlite /data/initial-db.sqlite
COPY init.sql /data/init.sql

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]