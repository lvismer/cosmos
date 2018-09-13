# Cosmos

A simple demo SPA that uses Vue (using [vue-cli](https://cli.vuejs.org/)) on the frontend and Lumen on the backend to cache the Astronomy Picture of the Day, courtesy of NASA.

The aim of the application is to demonstrate serving the frontend and backend from the same domain to avoid preflight CORS request.

The glue so to speak is the ```cosmos.localhost.conf``` *nginx* config file.
