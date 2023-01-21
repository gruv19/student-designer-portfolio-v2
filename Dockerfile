FROM nginx:1.23 as production

COPY default.conf /etc/nginx/conf.d/

EXPOSE 80