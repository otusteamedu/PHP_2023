cp conf/nginx.conf /etc/nginx/sites-available/default -f
sudo cp conf/supervisor.conf /etc/supervisor/conf.d/hw21.conf -f
cd ./app && sudo -u www-data composer install -q --ignore-platform-reqs
cd ./config && sudo -u www-data sed -i -- "s|%UNIX_SOCKET%|$1|g" config.ini
systemctl restart php8.1-fpm
systemctl restart nginx
sudo service supervisor restart