
cd docker
docker-compose up -d
sudo nano /etc/hosts 127.0.0.1 symfony-parse.local


docker-compose exec api bash
php bin/console doctrine:migrations:migrate

//php bin/console make:migration