# HabisIn

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

```
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=habisin
DB_USERNAME=root
DB_PASSWORD=
```

Konfigurasi object storage:

```
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=habisin
AWS_ENDPOINT=https://example.r2.cloudflarestorage.com
AWS_USE_PATH_STYLE_ENDPOINT=true

FILESYSTEM_DISK=s3
```

### 4. Generate app key
```
php artisan key:generate
```

### 5. Jalankan migrasi
```
php artisan migrate --seed
```

### 6. Jalankan aplikasi
```
php artisan serve
```
