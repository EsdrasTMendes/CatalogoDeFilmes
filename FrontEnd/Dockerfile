FROM node:18-alpine AS builder

WORKDIR /app

COPY ./FrontEnd/package.json ./FrontEnd/package-lock.json* ./
RUN npm ci

COPY ./FrontEnd/ /app/

ARG VITE_API_BASE_URL
ENV VITE_API_BASE_URL=$VITE_API_BASE_URL

RUN npm run build

FROM nginx:1.25-alpine
RUN rm /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=builder /app/dist /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]