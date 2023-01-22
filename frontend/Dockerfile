# development stage
FROM node:16.19-alpine as development

WORKDIR /app

EXPOSE 9000

COPY package*.json ./

RUN npm install

RUN mkdir node_modules/.cache && chmod -R 777 node_modules/.cache

RUN echo "VUE_APP_BACKEND_HOST=${BACKEND_HOST}" > .env

COPY ./ ./

USER root

CMD [ "npm", "run", "serve" ]


# build stage
FROM node:16.19-alpine as build

WORKDIR /app

COPY --from=development /app /app

RUN  npm run build


# production stage
FROM nginx:1.23 as production

COPY --from=build --chown=nginx:nginx /app/dist /app
COPY --from=build /app/default.conf /etc/nginx/conf.d/

EXPOSE 8081