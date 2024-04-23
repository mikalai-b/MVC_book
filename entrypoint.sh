#!/bin/sh

if [ ! -f /data/db.sqlite ]; then
    cp /data/initial-db.sqlite /data/db.sqlite
    chmod -R 777 /data/db.sqlite
    sqlite3 /data/db.sqlite < /data/init.sql
fi

exec "$@"
