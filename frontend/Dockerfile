FROM node:16.19-alpine

WORKDIR /app

EXPOSE 9000

COPY --chown=node:node package*.json ./

RUN npm install && chown -R node:node /app/node_modules

USER node

COPY --chown=node:node ./ ./

CMD [ "npm", "run", "serve" ]