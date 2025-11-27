# HabisIn

![Laravel Version](https://img.shields.io/badge/Laravel-v11.x-FF2D20?style=for-the-badge&logo=laravel)
![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/habisin/habisin/build.yml?branch=prod&style=for-the-badge)
[![habisin:dev](https://img.shields.io/badge/docker-habisin:latest-blue?style=for-the-badge&logo=docker&logoColor=white)](https://git.folflabs.com/folfcoder/-/packages/container/habisin/latest)


Platform marketplace yang menghubungkan penjual (restoran, cafe, UMKM, katering) dengan pembeli untuk menjual makanan sisa yang masih layak konsumsi dengan harga lebih murah.

Dengan mengurangi food waste, HabisIn mendukung SDG 2 (Zero Hunger) serta SDG 12 (Responsible Consumption and Production)

## Development

### 1. Clone repository
```bash
git clone https://github.com/habisin/habisin
cd habisin
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Setup .env
Copy file environment:

```bash
cp .env.example .env
```

Konfigurasi database:

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=habisin
DB_USERNAME=root
DB_PASSWORD=
```

Konfigurasi object storage:

```env
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=habisin
AWS_ENDPOINT=https://example.r2.cloudflarestorage.com
AWS_USE_PATH_STYLE_ENDPOINT=true

FILESYSTEM_DISK=s3
```

### 4. Generate app key
```bash
php artisan key:generate
```

### 5. Jalankan migrasi
```bash
php artisan migrate --seed
```

### 6. Jalankan aplikasi
```bash
php artisan serve
```

## Deployment dengan Docker Compose

Pastikan struktur folder sudah sesuai:
```
.
├── docker-compose.yml
├── .env
└── docker/
    └── nginx/
        └── default.conf
```

### docker-compose.yml
```yaml
services:
  habisin:
    image: git.folflabs.com/folfcoder/habisin:latest
    container_name: habisin
    env_file: ".env"
    volumes:
      - habisin_app:/var/www/html
    depends_on:
      - mariadb

  nginx:
    image: nginx:1.25
    container_name: habisin-nginx
    ports:
      - "9090:80"
    volumes:
      - habisin_app:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - habisin

  mariadb:
    image: mariadb:10.6
    container_name: habisin-mariadb
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: habisin
      MYSQL_USER: habisin
      MYSQL_PASSWORD: habisin
    volumes:
      - mariadb-data:/var/lib/mysql

volumes:
  mariadb-data:
  habisin_app:
```

### Jalankan aplikasi

```bash
docker compose up -d
```

### Perintah yang sering dipakai

#### Generate app key
```bash
docker exec -it habisin php artisan key:generate
```

#### Migrasi database
```bash
docker exec -it habisin php artisan migrate
```

#### Masuk ke container
```bash
docker exec -it habisin bash
```
