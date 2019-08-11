## Lamoda-PHP-Quest

- git clone https://github.com/AlxDeex/lamoda-logistic-api.git
- cd lamoda-logistic-api
- composer install
- docker-compose up -d
- docker exec -it app php artisan migrate
- docker exec -it app php artisan containers:generate --size 10 --unique 100 --count=1000


Для решения задачи о минимальном числе контейнеров, содержащих все уникальные товары
нуно найти множество, состоящее из симетрической разности множеств (контейнеров с товарами).
Товары которые попадут в итоговое множество будут находится  в нужных нам контейнерах

Алгоритм решения в PhotoStudioSetsController.php
