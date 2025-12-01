# VapeArt v2 - E-Commerce Platform

Modern Laravel tabanlı e-ticaret platformu. Filament admin paneli, çoklu dil desteği, Elasticsearch entegrasyonu ve gelişmiş ürün yönetimi özellikleri ile donatılmıştır.

## 🚀 Özellikler

- **Laravel 12** - Modern PHP framework
- **Filament 4** - Güçlü admin paneli
- **Elasticsearch** - Gelişmiş ürün arama
- **Çoklu Dil Desteği** - Spatie Translatable
- **Medya Yönetimi** - Spatie Media Library
- **Rol ve İzin Yönetimi** - Spatie Permission
- **Cache Yönetimi** - Gelişmiş cache stratejileri
- **Queue Sistemi** - Arka plan işlemleri

## 📋 Gereksinimler

- PHP >= 8.2
- Composer
- Node.js >= 18.x ve NPM
- MySQL/PostgreSQL
- Elasticsearch 7.x veya 8.x
- Java 17+ (Elasticsearch için)

## 🔧 Kurulum

### 1. Projeyi Klonlayın

```bash
git clone <repository-url>
cd vapeart-v2
```

### 2. Bağımlılıkları Yükleyin

```bash
# PHP bağımlılıkları
composer install

# Node.js bağımlılıkları
npm install
```

### 3. Ortam Değişkenlerini Ayarlayın

```bash
cp .env.example .env
php artisan key:generate
```

`.env` dosyasını düzenleyin ve veritabanı, Elasticsearch ve diğer servis bilgilerini ekleyin.

### 4. Veritabanını Oluşturun

```bash
php artisan migrate
php artisan db:seed
```

### 5. Frontend Assets'leri Derleyin

```bash
npm run build
# veya development için
npm run dev
```

### 6. Storage Link Oluşturun

```bash
php artisan storage:link
```

## 🔍 Elasticsearch Kurulumu

### macOS (Homebrew)

#### 1. Elasticsearch Tap'ını Ekleyin

```bash
brew tap elastic/tap
```

#### 2. Elasticsearch'i Kurun

```bash
brew install elastic/tap/elasticsearch-full
```

#### 3. Config Dosyasını Düzenleyin

`/opt/homebrew/etc/elasticsearch/elasticsearch.yml` dosyasını açın ve şu ayarları ekleyin:

```yaml
network.host: 127.0.0.1
http.port: 9200
discovery.type: single-node
xpack.ml.enabled: false
```

#### 4. Elasticsearch'i Başlatın

```bash
# Java home'u ayarlayın
export ES_JAVA_HOME=$(/usr/libexec/java_home)
export JAVA_HOME=$(/usr/libexec/java_home)

# Elasticsearch'i başlatın
elasticsearch -d
```

Veya proje kök dizinindeki script'i kullanın:

```bash
./start-elasticsearch.sh
```

#### 5. Bağlantıyı Test Edin

```bash
curl -X GET "localhost:9200/?pretty"
```

#### 6. Otomatik Başlatma (Opsiyonel)

Mac'te otomatik başlatma için LaunchAgent kullanabilirsiniz:

```bash
# LaunchAgent dosyası zaten oluşturulmuş olmalı
# ~/Library/LaunchAgents/com.elasticsearch.plist

# Servisi yükleyin
launchctl load ~/Library/LaunchAgents/com.elasticsearch.plist

# Servisi başlatın
launchctl start com.elasticsearch

# Servisi durdurmak için
launchctl stop com.elasticsearch
```

### Ubuntu 22.04

#### 1. Java 17 Kurulumu

```bash
sudo apt update
sudo apt install openjdk-17-jdk -y

# Java versiyonunu kontrol edin
java -version
```

#### 2. Elasticsearch GPG Key Ekleyin

```bash
wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo gpg --dearmor -o /usr/share/keyrings/elasticsearch-keyring.gpg
```

#### 3. Elasticsearch Repository Ekleyin

```bash
echo "deb [signed-by=/usr/share/keyrings/elasticsearch-keyring.gpg] https://artifacts.elastic.co/packages/7.x/apt stable main" | sudo tee /etc/apt/sources.list.d/elastic-7.x.list
```

#### 4. Elasticsearch'i Kurun

```bash
sudo apt update
sudo apt install elasticsearch -y
```

#### 5. Elasticsearch Config Dosyasını Düzenleyin

```bash
sudo nano /etc/elasticsearch/elasticsearch.yml
```

Şu ayarları ekleyin/düzenleyin:

```yaml
network.host: 127.0.0.1
http.port: 9200
discovery.type: single-node
xpack.ml.enabled: false
```

#### 6. JVM Heap Size Ayarlayın (Opsiyonel)

```bash
sudo nano /etc/elasticsearch/jvm.options
```

Aşağıdaki satırları bulun ve düzenleyin (RAM'inize göre):

```
-Xms512m
-Xmx512m
```

#### 7. Elasticsearch'i Başlatın ve Etkinleştirin

```bash
# Elasticsearch'i başlatın
sudo systemctl start elasticsearch

# Sistem açılışında otomatik başlatma için
sudo systemctl enable elasticsearch

# Durumu kontrol edin
sudo systemctl status elasticsearch
```

#### 8. Bağlantıyı Test Edin

```bash
curl -X GET "localhost:9200/?pretty"
```

#### 9. Firewall Ayarları (Eğer firewall aktifse)

```bash
sudo ufw allow 9200/tcp
```

### Elasticsearch Index Oluşturma

Proje kurulumundan sonra Elasticsearch index'ini oluşturun:

```bash
php artisan tinker
```

```php
app(\App\Services\ElasticsearchService::class)->createIndex();
```

## 📦 Ürün İmport Sistemi (External API)

Bu sistem harici bir API'den ürünleri çekip veritabanına aktarmanızı sağlar.

### Özellikler

- **Pagination Desteği**: API'deki tüm sayfaları otomatik gezer
- **Çoklu Dil Desteği**: az, en, ru çevirileri otomatik import edilir
- **İlişki Yönetimi**: Brand, Category, Tag otomatik oluşturulur veya mevcut kullanılır
- **Medya İmport**: Base image ve additional images Spatie Media Library ile import edilir
- **Duplicate Kontrolü**: SKU veya slug üzerinden mevcut ürünler güncellenir
- **Progress Tracking**: Gerçek zamanlı ilerleme göstergesi

### API Veri Yapısı

Import servisi aşağıdaki API yapısını destekler:

```json
{
  "data": [
    {
      "id": 1,
      "sku": "PRD-001",
      "slug": "product-slug",
      "title": "Product Name",
      "new_price": 29.99,
      "old_price": 39.99,
      "smoke_count": 100,
      "is_stock": true,
      "is_new": true,
      "is_best_seller": false,
      "translations": {
        "az": { "title": "...", "description": "...", "info": "..." },
        "en": { "title": "...", "description": "...", "info": "..." },
        "ru": { "title": "...", "description": "...", "info": "..." }
      },
      "brand": { "slug": "brand-slug", "title": "Brand Name", "translations": {...} },
      "category": { "slug": "cat-slug", "title": "Category", "parent": {...} },
      "tags": [{ "slug": "tag-1", "name": "Tag 1" }],
      "base_image": { "url": "https://..." },
      "additional_images": [{ "url": "https://..." }]
    }
  ],
  "meta": { "current_page": 1, "last_page": 10 }
}
```

### Field Mapping (API → Database)

| API Field | DB Field | Açıklama |
|-----------|----------|----------|
| `new_price` | `price` | Güncel satış fiyatı |
| `old_price` | `compare_at_price` | Eski/karşılaştırma fiyatı |
| `is_stock` | `is_active` | Stok durumu |
| `is_best_seller` | `is_featured` | Öne çıkan ürün |
| `smoke_count` | `stock_qty` | Stok miktarı |
| `translations.{locale}.title` | `name` | Ürün adı (JSON) |
| `translations.{locale}.description` | `description` | Açıklama (JSON) |
| `translations.{locale}.info` | `specs` | Teknik özellikler (JSON) |
| `base_image` | `thumbnail` collection | Ana ürün görseli |
| `additional_images` | `images` collection | Ek görseller |

### Kullanım

#### Manuel Import (Progress Bar ile)

```bash
# Default API URL'den import
php artisan products:import

# Özel API URL'den import
php artisan products:import http://example.com/api/products

# Örnek: Local API'den import
php artisan products:import http://127.0.0.1:8001/api/products
```

#### Queue ile Import (Arkaplanda)

```bash
# Queue'ya ekle
php artisan products:import http://127.0.0.1:8001/api/products --queue

# Queue worker'ı başlat (ayrı terminalde)
php artisan queue:work
```

### Çıktı Örneği

```
Starting product import from: http://127.0.0.1:8001/api/products

 607 products processed [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] Imported: 605 | Updated: 2 | Failed: 0

Import completed!
+------------------+-------+
| Metric           | Count |
+------------------+-------+
| New Products     | 605   |
| Updated Products | 2     |
| Failed           | 0     |
| Total Processed  | 607   |
+------------------+-------+
```

### API URL Konfigürasyonu

Default API URL'i `.env` dosyasında ayarlayabilirsiniz:

```env
PRODUCT_API_URL=http://127.0.0.1:8001/api/products
```

Veya `config/services.php` içinde:

```php
'product_api' => [
    'url' => env('PRODUCT_API_URL', 'http://127.0.0.1:8001/api/products'),
],
```

### Import Servisi Dosyaları

| Dosya | Açıklama |
|-------|----------|
| `app/Services/ProductImportService.php` | Ana import logic |
| `app/Services/Contracts/ProductImportServiceInterface.php` | Interface |
| `app/Console/Commands/ImportProductsFromApi.php` | Artisan command |
| `app/Jobs/ImportProductsJob.php` | Queue job |

## 📝 Blog İmport Sistemi (External API)

Bu sistem harici bir API'den blog yazılarını çekip veritabanına aktarmanızı sağlar.

### Özellikler

- **Pagination Desteği**: API'deki tüm sayfaları otomatik gezer
- **Çoklu Dil Desteği**: Aynı içerik tüm dillere (az, en, ru) kopyalanır
- **Medya İmport**: Featured image Spatie Media Library ile import edilir
- **Duplicate Kontrolü**: Slug üzerinden mevcut bloglar güncellenir
- **Otomatik Excerpt**: Description'dan otomatik excerpt oluşturulur
- **Okuma Süresi**: İçeriğe göre otomatik okuma süresi hesaplanır

### API Veri Yapısı

Import servisi aşağıdaki API yapısını destekler:

```json
{
  "data": [
    {
      "id": 1,
      "slug": "blog-slug",
      "status": 1,
      "sort": 1,
      "title": "Blog Başlığı",
      "description": "<p>Blog içeriği HTML formatında...</p>",
      "base_image": {
        "url": "http://example.com/image.jpg"
      },
      "created_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "meta": { "current_page": 1, "last_page": 1 }
}
```

### Field Mapping (API → Database)

| API Field | DB Field | Açıklama |
|-----------|----------|----------|
| `slug` | `slug` | URL-friendly tanımlayıcı |
| `status` | `is_active` | Yayın durumu |
| `sort` | `sort_order` | Sıralama |
| `title` | `title` | Başlık (tüm dillere) |
| `description` | `body` | İçerik (tüm dillere) |
| `description` (ilk 200 karakter) | `excerpt` | Özet (tüm dillere) |
| `created_at` | `published_at` | Yayınlanma tarihi |
| `base_image` | `featured` collection | Öne çıkan görsel |

### Kullanım

#### Manuel Import (Progress Bar ile)

```bash
# Default API URL'den import
php artisan blogs:import

# Özel API URL'den import
php artisan blogs:import http://example.com/api/posts

# Örnek: Local API'den import
php artisan blogs:import http://127.0.0.1:8001/api/posts
```

#### Queue ile Import (Arkaplanda)

```bash
# Queue'ya ekle
php artisan blogs:import http://127.0.0.1:8001/api/posts --queue

# Queue worker'ı başlat (ayrı terminalde)
php artisan queue:work
```

### Çıktı Örneği

```
Starting blog import from: http://127.0.0.1:8001/api/posts

 2 blogs processed [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] Imported: 2 | Updated: 0 | Failed: 0

Import completed!
+------------------+-------+
| Metric           | Count |
+------------------+-------+
| New Blogs        | 2     |
| Updated Blogs    | 0     |
| Failed           | 0     |
| Total Processed  | 2     |
+------------------+-------+
```

### API URL Konfigürasyonu

Default API URL'i `.env` dosyasında ayarlayabilirsiniz:

```env
BLOG_API_URL=http://127.0.0.1:8001/api/posts
```

### Blog Import Dosyaları

| Dosya | Açıklama |
|-------|----------|
| `app/Services/BlogImportService.php` | Ana import logic |
| `app/Services/Contracts/BlogImportServiceInterface.php` | Interface |
| `app/Console/Commands/ImportBlogsFromApi.php` | Artisan command |
| `app/Jobs/ImportBlogsJob.php` | Queue job |

## 🔄 Elasticsearch Senkronizasyonu

Bu sistem veritabanındaki ürünleri Elasticsearch'e senkronize eder.

### Özellikler

- **Toplu Senkronizasyon**: Tüm aktif ürünleri batch halinde indexler
- **Fresh Sync**: Index'i silip sıfırdan oluşturma
- **Chunk İşleme**: Bellek optimizasyonu için chunk'lar halinde işleme
- **Otomatik Zamanlama**: Günlük gece yarısı otomatik sync
- **Progress Bar**: Gerçek zamanlı ilerleme göstergesi
- **Inaktif Temizleme**: İnaktif ürünleri index'ten kaldırır

### Kullanım

#### Manuel Senkronizasyon

```bash
# Normal sync (mevcut index'e ekle/güncelle)
php artisan elasticsearch:sync

# Fresh sync (index'i sil ve yeniden oluştur)
php artisan elasticsearch:sync --fresh

# Özel chunk boyutu ile
php artisan elasticsearch:sync --chunk=200
```

#### Parametreler

| Parametre | Default | Açıklama |
|-----------|---------|----------|
| `--fresh` | false | Index'i silip yeniden oluşturur |
| `--chunk` | 100 | Her batch'te işlenecek ürün sayısı |

### Çıktı Örneği

```
Starting Elasticsearch sync...

Index ready.
Found 607 active products to sync.

 607/607 [▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓] 100% | Synced: product-slug

Sync completed!
+------------------+-------+
| Metric           | Count |
+------------------+-------+
| Synced           | 607   |
| Failed           | 0     |
| Total Processed  | 607   |
+------------------+-------+
```

### Otomatik Zamanlama (Schedule)

Elasticsearch sync her gece **00:00**'da otomatik çalışır.

**Konfigürasyon:** `routes/console.php`

```php
Schedule::command('elasticsearch:sync')->dailyAt('00:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/elasticsearch-sync.log'));
```

**Scheduler'ın çalışması için:**

Local development:
```bash
php artisan schedule:work
```

Production (crontab):
```bash
* * * * * cd /var/www/vapeart-v2 && php artisan schedule:run >> /dev/null 2>&1
```

### Log Dosyası

Otomatik sync logları: `storage/logs/elasticsearch-sync.log`

### Senkronizasyon Dosyaları

| Dosya | Açıklama |
|-------|----------|
| `app/Console/Commands/SyncProductsToElasticsearch.php` | Artisan command |
| `app/Services/ElasticsearchService.php` | Elasticsearch işlemleri |
| `routes/console.php` | Schedule tanımı |

## 🔁 Tam İş Akışı (Import + Sync)

Yeni ürünleri import edip Elasticsearch'e senkronize etmek için:

```bash
# 1. Ürünleri API'den import et
php artisan products:import http://127.0.0.1:8001/api/products

# 2. Elasticsearch'e senkronize et
php artisan elasticsearch:sync

# Veya fresh sync (önerilir ilk kurulumda)
php artisan elasticsearch:sync --fresh
```

### Queue ile İş Akışı

```bash
# Terminal 1: Queue worker başlat
php artisan queue:work

# Terminal 2: Import'u queue'ya ekle
php artisan products:import http://127.0.0.1:8001/api/products --queue

# Import tamamlandıktan sonra sync
php artisan elasticsearch:sync
```

## ⚙️ Yapılandırma

### .env Dosyası Ayarları

```env
# Elasticsearch Configuration
SCOUT_DRIVER=elasticsearch
ELASTICSEARCH_INDEX=vapeart
ELASTICSEARCH_HOST=localhost
ELASTICSEARCH_PORT=9200
ELASTICSEARCH_SCHEME=http
ELASTICSEARCH_USER=
ELASTICSEARCH_PASS=

# Product Import API
PRODUCT_API_URL=http://127.0.0.1:8001/api/products

# Blog Import API
BLOG_API_URL=http://127.0.0.1:8001/api/posts
```

### Cache Yönetimi

Proje gelişmiş cache stratejileri kullanır. Cache'i temizlemek için:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🎯 Kullanım

### Development Server

```bash
php artisan serve
```

### Queue Worker

#### Local Development (Manuel)

```bash
php artisan queue:work
```

#### Local Development (Sürekli Çalıştırma)

**Yöntem 1: Arka Planda Çalıştırma (Terminal'de)**

```bash
# Yeni bir terminal açın ve şu komutu çalıştırın:
php artisan queue:work --daemon

# Veya belirli bir queue için:
php artisan queue:work --queue=default --daemon
```

**Yöntem 2: Screen veya tmux Kullanarak**

```bash
# Screen kurulumu (macOS)
brew install screen

# Screen oturumu başlat
screen -S queue-worker

# Queue worker'ı başlat
php artisan queue:work

# Screen'den çıkmak için: Ctrl+A, sonra D
# Tekrar bağlanmak için: screen -r queue-worker
```

**Yöntem 3: macOS LaunchAgent ile Otomatik Başlatma**

Proje kök dizininde `com.vapeart.queue.plist.example` dosyasını bulun ve kopyalayın:

```bash
# Örnek dosyayı kopyalayın
cp com.vapeart.queue.plist.example ~/Library/LaunchAgents/com.vapeart.queue.plist

# Dosyayı düzenleyin (PHP yolunu ve proje yolunu kendi sisteminize göre değiştirin)
nano ~/Library/LaunchAgents/com.vapeart.queue.plist
```

**Önemli:** Dosyada şu değerleri değiştirin:
- `YOUR_USERNAME`: Kendi kullanıcı adınız
- PHP yolu: `which php` komutu ile PHP yolunuzu bulun (genellikle `/opt/homebrew/opt/php@8.2/bin/php` veya `/usr/bin/php`)

**LaunchAgent'ı yükleyin:**

```bash
# LaunchAgent'ı yükle
launchctl load ~/Library/LaunchAgents/com.vapeart.queue.plist

# Başlat
launchctl start com.vapeart.queue

# Durumu kontrol et
launchctl list | grep vapeart

# Logları kontrol et
tail -f ~/Projects/vapeart-v2/storage/logs/queue-worker.log

# Durdurmak için
launchctl stop com.vapeart.queue

# Kaldırmak için
launchctl unload ~/Library/LaunchAgents/com.vapeart.queue.plist
```

**Yöntem 4: Laravel Horizon (Gelişmiş Queue Yönetimi)**

```bash
composer require laravel/horizon
php artisan horizon:install
php artisan migrate
php artisan horizon
```

### Scheduler (Günlük Sync için)

#### Local Development

```bash
php artisan schedule:work
```

#### Production (Cron Job)

`crontab -e` komutu ile şu satırı ekleyin:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Composer Scripts

```bash
# Development ortamı (server, queue, logs, vite)
composer dev

# Test çalıştırma
composer test
```

## 📁 Proje Yapısı

```
vapeart-v2/
├── app/
│   ├── Enums/              # Enum sınıfları
│   ├── Filament/           # Filament admin paneli
│   ├── Http/               # Controllers, Middleware
│   ├── Models/             # Eloquent modelleri
│   ├── Repositories/       # Repository pattern
│   ├── Services/           # Business logic
│   └── Jobs/               # Queue job'ları
├── config/                 # Konfigürasyon dosyaları
├── database/               # Migrations, seeders
├── resources/
│   ├── views/              # Blade template'leri
│   ├── js/                 # JavaScript dosyaları
│   └── css/                # CSS dosyaları
├── routes/                 # Route tanımları
└── public/                 # Public assets
```

## 🔐 Güvenlik

- `.env` dosyasını asla commit etmeyin
- Production'da `APP_DEBUG=false` olmalı
- Güçlü `APP_KEY` kullanın
- Database şifrelerini güvenli tutun

## 🧪 Test

```bash
php artisan test
```

## 📝 Önemli Notlar

### Elasticsearch Versiyonu

Proje Elasticsearch 8.x ile uyumludur. Eğer Elasticsearch 7.x kullanıyorsanız, `ElasticsearchService.php` dosyasındaki namespace'leri güncellemeniz gerekebilir.

### Cache Stratejisi

- Product, Menu, Banner gibi modeller otomatik cache'lenir
- Cache TTL: 3600 saniye (1 saat)
- Filament'te create/update/delete işlemlerinde cache otomatik temizlenir

### Günlük Elasticsearch Sync

`elasticsearch:sync` komutu her gece 00:00'da otomatik çalışır ve tüm aktif ürünleri Elasticsearch'e senkronize eder.

```bash
# Manuel çalıştırma
php artisan elasticsearch:sync

# Fresh sync (index'i yeniden oluştur)
php artisan elasticsearch:sync --fresh
```

Scheduler'ın çalıştığından emin olun (crontab veya `php artisan schedule:work`).

## 🔄 Queue Worker Yönetimi (Ubuntu Server)

### Supervisor ile Queue Worker Kurulumu

Supervisor, queue worker'ları sürekli çalıştırmak ve otomatik olarak yeniden başlatmak için kullanılır.

#### 1. Supervisor Kurulumu

```bash
sudo apt update
sudo apt install supervisor -y
```

#### 2. Supervisor Konfigürasyon Dosyası Oluşturun

Proje kök dizininde `vapeart-queue-worker.conf.example` dosyasını bulun ve kopyalayın:

```bash
# Örnek dosyayı kopyalayın
sudo cp vapeart-queue-worker.conf.example /etc/supervisor/conf.d/vapeart-queue-worker.conf

# Dosyayı düzenleyin (proje yolunu kendi yolunuzla değiştirin)
sudo nano /etc/supervisor/conf.d/vapeart-queue-worker.conf
```

Veya manuel olarak oluşturun:

```bash
sudo nano /etc/supervisor/conf.d/vapeart-queue-worker.conf
```

Aşağıdaki içeriği ekleyin (proje yolunu kendi yolunuzla değiştirin):

```ini
[program:vapeart-queue-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/vapeart-v2/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/vapeart-v2/storage/logs/queue-worker.log
stopwaitsecs=3600
```

**Açıklamalar:**
- `command`: Queue worker komutu (proje yolunu değiştirin)
- `user`: Web sunucusu kullanıcısı (genellikle `www-data` veya `nginx`)
- `numprocs`: Aynı anda çalışacak worker sayısı (2 önerilir)
- `stdout_logfile`: Log dosyası yolu
- `--sleep=3`: İş yokken 3 saniye bekle
- `--tries=3`: Başarısız işler için 3 deneme
- `--max-time=3600`: Worker'ın 1 saatte bir yeniden başlatılması (memory leak önleme)

#### 3. Supervisor'ı Yeniden Yükleyin

```bash
# Konfigürasyonu kontrol edin
sudo supervisorctl reread

# Worker'ı ekleyin
sudo supervisorctl update

# Worker'ı başlatın
sudo supervisorctl start vapeart-queue-worker:*

# Durumu kontrol edin
sudo supervisorctl status
```

#### 4. Supervisor Komutları

```bash
# Tüm worker'ları başlat
sudo supervisorctl start vapeart-queue-worker:*

# Tüm worker'ları durdur
sudo supervisorctl stop vapeart-queue-worker:*

# Tüm worker'ları yeniden başlat
sudo supervisorctl restart vapeart-queue-worker:*

# Durumu kontrol et
sudo supervisorctl status vapeart-queue-worker:*

# Logları görüntüle
sudo tail -f /var/www/vapeart-v2/storage/logs/queue-worker.log
```

#### 5. Laravel Horizon ile (Opsiyonel - Gelişmiş)

Horizon kullanıyorsanız, Supervisor konfigürasyonu:

```ini
[program:vapeart-horizon]
process_name=%(program_name)s
command=php /var/www/vapeart-v2/artisan horizon
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/vapeart-v2/storage/logs/horizon.log
stopwaitsecs=3600
```

### Cron Job Kurulumu (Scheduler için)

Laravel scheduler'ın çalışması için cron job ekleyin:

```bash
sudo crontab -e -u www-data
```

Şu satırı ekleyin (proje yolunu değiştirin):

```bash
* * * * * cd /var/www/vapeart-v2 && php artisan schedule:run >> /dev/null 2>&1
```

Veya root kullanıcısı için:

```bash
sudo crontab -e
```

```bash
* * * * * cd /var/www/vapeart-v2 && php artisan schedule:run >> /dev/null 2>&1
```

### Queue Worker Sorun Giderme

#### Worker Çalışmıyor

```bash
# Supervisor loglarını kontrol edin
sudo tail -f /var/log/supervisor/supervisord.log

# Worker loglarını kontrol edin
sudo tail -f /var/www/vapeart-v2/storage/logs/queue-worker.log

# Worker'ı manuel test edin
cd /var/www/vapeart-v2
php artisan queue:work --once
```

#### Worker Sürekli Yeniden Başlıyor

```bash
# Supervisor durumunu kontrol edin
sudo supervisorctl status

# Detaylı logları inceleyin
sudo tail -100 /var/www/vapeart-v2/storage/logs/queue-worker.log

# PHP hatalarını kontrol edin
sudo tail -f /var/log/php8.2-fpm.log  # PHP versiyonunuza göre değiştirin
```

#### Queue İşleri İşlenmiyor

```bash
# Queue durumunu kontrol edin
php artisan queue:failed

# Başarısız işleri tekrar deneyin
php artisan queue:retry all

# Veritabanı queue kullanıyorsanız tabloyu kontrol edin
php artisan tinker
>>> DB::table('jobs')->count();
```

## 🐛 Sorun Giderme

### Elasticsearch Bağlantı Hatası

```bash
# Elasticsearch'in çalıştığını kontrol edin
curl -X GET "localhost:9200/?pretty"

# Logları kontrol edin
# macOS: /opt/homebrew/var/log/elasticsearch/
# Ubuntu: /var/log/elasticsearch/
```

### Java Hatası

```bash
# Java versiyonunu kontrol edin
java -version

# ES_JAVA_HOME'u ayarlayın
export ES_JAVA_HOME=$(/usr/libexec/java_home)  # macOS
export ES_JAVA_HOME=/usr/lib/jvm/java-17-openjdk-amd64  # Ubuntu
```

### Index Oluşturma Hatası

```bash
# Mevcut index'leri kontrol edin
curl -X GET "localhost:9200/_cat/indices?v"

# Index'i silip yeniden oluşturun
curl -X DELETE "localhost:9200/vapeart"
php artisan tinker
>>> app(\App\Services\ElasticsearchService::class)->createIndex();
```

## 📚 Teknolojiler

- **Backend**: Laravel 12, PHP 8.2+
- **Admin Panel**: Filament 4
- **Frontend**: Vite, TailwindCSS
- **Search**: Elasticsearch 8.x
- **Database**: MySQL/PostgreSQL
- **Cache**: Redis/File
- **Queue**: Database/Redis

## 📄 Lisans

Bu proje özel bir projedir.

## 👥 Geliştirici

VapeArt Development Team

---

**Not**: Production ortamında Elasticsearch için güvenlik ayarlarını yapılandırmayı unutmayın!
