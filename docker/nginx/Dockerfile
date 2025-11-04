FROM nginx:stable-alpine

WORKDIR /www
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

RUN adduser -D www-data -G www-data

EXPOSE 80
