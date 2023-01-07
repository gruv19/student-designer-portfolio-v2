# development stage
FROM node:16.19-alpine as development

WORKDIR /app

EXPOSE 9000

COPY package*.json ./

RUN npm install

RUN mkdir node_modules/.cache && chmod -R 777 node_modules/.cache

COPY ./ ./

USER root

RUN  npm run build

CMD [ "npm", "run", "serve" ]

# production stage
FROM nginx:1.23 as production

COPY --from=development /app/dist /usr/share/nginx/html/
RUN sed -i "s/index\s\sindex.html\sindex.htm;/index  index.html index.htm;\n\ttry_files \$uri \$uri\/ \/index.html;/" /etc/nginx/conf.d/default.conf

EXPOSE 80