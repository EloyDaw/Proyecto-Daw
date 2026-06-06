# Proyecto de Colaboradores en GitHub

Página simple que registra visitas en MySQL.

## Cómo levantar

1. Asegúrate de tener los siguientes archivos:
   
   - `docker-compose.yml` (el que ya tienes)
   - `Caddyfile`
   - Carpeta `src/` con tu `index.php` dentro
   - Carpeta `php/` con tu `Dockerfile` para PHP

2. Ejecuta:

docker compose up -d --build

3. Abre el navegador en:
http://localhost

## Notas

Cada recarga cuenta como una visita.
Base de datos: demo → usuario dwes / contraseña dwes
Para parar: docker compose down
