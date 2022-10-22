FROM nginx:1.22.1-alpine as core
# https://stackoverflow.com/questions/56649582/substitute-environment-variables-in-nginx-config-from-docker-compose

RUN mkdir -p /etc/nginx/templates /var/www/html/webroot
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/conf.d/*.template /etc/nginx/templates/
COPY ./webroot /var/www/html/webroot/

CMD ["nginx", "-g", "daemon off;"]

FROM core as develop
