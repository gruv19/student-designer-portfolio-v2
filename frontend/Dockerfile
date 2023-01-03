FROM node:16.19-alpine

WORKDIR /app

EXPOSE 9000

COPY package*.json ./

RUN npm install

RUN mkdir node_modules/.cache && chmod -R 777 node_modules/.cache

USER root

COPY ./ ./

CMD [ "npm", "run", "serve" ]