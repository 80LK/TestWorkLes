# Dev

Установить Symfony-CLI
https://symfony.com/download

Указать данные к базе дынных в .env

установить зависимости
```
composer install

yarn install
```

Мигрировать базу
```
php ./bin/console doctrine:migration:migrate
```

Запустить Encore
```
yarn encore dev-server
```

Запустить symfony
```
symfony server:start
```
