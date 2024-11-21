https://github.com/igorsgm/laravel-git-hooks
https://codingwisely.com/blog/how-to-run-pint-and-pest-on-git-hooks-with-laravel-sail

´´´sh
docker run --rm \  
 -u "$(id -u):$(id -g)" \
 -v "$(pwd):/var/www/html" \
 -w /var/www/html \
 laravelsail/php83-composer:latest \
 composer install --ignore-platform-reqs
´´´
