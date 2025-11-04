#!/bin/bash


if [ ! -z "$WWWUSER" ]; then
    usermod -u $WWWUSER www-data
fi

exec "$@"