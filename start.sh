docker compose up -d
docker exec -it php bash
composer install
php bin/console d:m:m
echo "Deployment completed!"
