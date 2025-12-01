# Contact Page Configuration

Contact sayfası için `.env` dosyasına eklenmesi gereken config'ler:

## Google Maps API Key

```env
GOOGLE_MAPS_API_KEY=your_google_maps_api_key_here
```

Google Maps API key almak için:
1. [Google Cloud Console](https://console.cloud.google.com/)'a gidin
2. Yeni bir proje oluşturun veya mevcut projeyi seçin
3. "APIs & Services" > "Library" bölümüne gidin
4. "Maps JavaScript API"yi etkinleştirin
5. "APIs & Services" > "Credentials" bölümüne gidin
6. "Create Credentials" > "API Key" seçin
7. Oluşturulan API key'i kopyalayın ve `.env` dosyasına ekleyin

## Contact Form Email Address (Opsiyonel)

```env
MAIL_CONTACT_TO_ADDRESS=admin@example.com
```

Bu ayar belirtilmezse, contact form mesajları `MAIL_FROM_ADDRESS` adresine gönderilir.

## Mail Configuration

Mail gönderimi için aşağıdaki ayarları yapılandırın:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Your App Name"
```

### Örnek SMTP Ayarları

**Mailtrap (Test için):**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

**Gmail:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

**SendGrid:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_ENCRYPTION=tls
```

## Tüm Gerekli Config'ler Özeti

```env
# Google Maps
GOOGLE_MAPS_API_KEY=your_google_maps_api_key_here

# Contact Form Email (opsiyonel)
MAIL_CONTACT_TO_ADDRESS=admin@example.com

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Your App Name"
```

## Notlar

- Google Maps API key olmadan harita çalışmaz, ancak sayfa yine de açılır
- Mail ayarları yapılmazsa contact form mesajları gönderilmez ama veritabanına kaydedilir
- `MAIL_CONTACT_TO_ADDRESS` belirtilmezse, mesajlar `MAIL_FROM_ADDRESS` adresine gönderilir

