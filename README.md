# bittest.dev

## Разворачиваем в DEV окружении
Необходимый софт `docker`, `docker-compose`(с поддержкой 2 версии Dockerfile)

### Окружение
 * `docker-compose up -d`
 * `docker exec -i bittest_frontend_php_1 composer install`

### Сеть
 * `docker network disconnect bittest_default bittest_frontend_nginx_1`
 * `docker network connect bittest_default bittest_frontend_nginx_1 --alias=bittest.dev`
 * `docker network connect bridge bittest_frontend_nginx_1`
 * `su -c "sed -i '/[0-9\.] bittest.dev/d' /etc/hosts && echo $(docker inspect -f '{{.NetworkSettings.IPAddress}}' bittest_frontend_nginx_1) bittest.dev >> /etc/hosts"`

### Конфиг (app\Safely\config.php)
Переименовать файл настроек `config.example` в `config.php`

```
return [
    'db_host' => 'mysql',
    'db_name' => 'bittest',
    'db_user' => 'root',
    'db_pass' => 'rootpass'
];
```

### БД 
 * Импорт БД
`docker exec -i bittest_frontend_db_1 sh -c 'mysql -uroot -prootpass bittest' < /PATH/TO/dump/bittest.sql`
 * Проверка
`docker exec -i bittest_frontend_db_1 mysql -uroot -prootpass -e 'show databases;'`
`docker exec -i bittest_frontend_db_1 mysql -uroot -prootpass -D bittest -e 'show tables;'`
 * Консоль
`docker exec -it bittest_frontend_db_1 mysql -uroot -prootpass`
 * Экспорт БД
`docker exec bittest_frontend_db_1 sh -c 'exec mysqldump --all-databases -uroot -prootpass' > /PATH/TO/NEW/dump/bittest.sql`

