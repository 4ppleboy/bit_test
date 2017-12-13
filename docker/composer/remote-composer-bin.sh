#!/usr/bin/env bash

#хак для обновления зависимостей через PHPStorm

args_string=''
for arg in "$@"
do
    args_string+=' '
    args_string+=${arg}
done

`docker exec bittest_frontend_php_1 composer ${args_string}`