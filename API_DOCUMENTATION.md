# API Documentation - BNNK Surabaya WhatsApp Bot

## Base URL
```
http://localhost:8000 (Development)
https://yourdomain.com (Production)
```

## Authentication
- Webhook verification menggunakan `WHATSAPP_VERIFY_TOKEN`
- Semua endpoint publik untuk testing saat development

## Endpoints

### 1. Bot Information
**GET** `/`
```json
{
  "app": "BNNK Surabaya WhatsApp Bot",
  "version": "1.0.0",
  "status": "active"
}
```

### 2. Bot Status Check
**GET** `/api/test`
```json
{
  "message": "BNNK Surabaya WhatsApp Bot is running",
  "timestamp": "2024-09-26 15:42:12",
  "config": {
    "verify_token_set": "Yes",
    "access_token_set": "Yes",
    "phone_id_set": "Yes"
  }
}
```

### 3. WhatsApp Webhook
**GET/POST** `/api/whatsapp/webhook`

#### Verification (GET)
```
?hub_mode=subscribe
&hub_challenge=123456789
&hub_verify_token=bnnk_surabaya_2024_verify_token
```

#### Message Receive (POST)
```json
{
  "entry": [{
    "changes": [{
      "value": {
        "messages": [{
          "from": "628123456789",
          "id": "wamid.xxx",
          "timestamp": "1695720000",
          "text": {
            "body": "menu"
          }
        }],
        "contacts": [{
          "profile": {
            "name": "User Name"
          },
          "wa_id": "628123456789"
        }]
      }
    }]
  }]
}
```

### 4. Admin Dashboard
**GET** `/admin/dashboard`
```json
{
  "total_messages": 0,
  "messages_today": 0,
  "active_sessions": 0,
  "total_users": 0,
  "popular_services": []
}
```

### 5. Conversation Logs
**GET** `/admin/logs?phone=628xxx&date=2024-09-26`
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "phone_number": "628123456789",
      "contact_name": "User Name",
      "message_in": "menu",
      "message_out": "📋 Menu Layanan BNNK Surabaya...",
      "created_at": "2024-09-26T15:42:12.000000Z"
    }
  ],
  "per_page": 50,
  "total": 1
}
```

### 6. Analytics Data
**GET** `/admin/analytics`
```json
{
  "messages_by_date": [
    {"date": "2024-09-26", "count": 5}
  ],
  "service_requests": [
    {"service": "Rehabilitasi Medis", "count": 3}
  ],
  "response_times": {
    "average": "2.3 seconds",
    "fastest": "0.8 seconds",
    "slowest": "5.1 seconds"
  },
  "user_engagement": {
    "new_users_today": 2,
    "returning_users": 1,
    "average_messages_per_user": 2.5
  }
}
```

## Bot Commands

### Menu Commands
- `menu`, `layanan`, `info`, `help`, `bantuan`
- Response: Menu layanan BNNK

### Service Selection
- `1-6` atau nama layanan
- `rehabilitasi`, `konseling`, `tes urine`, `penyuluhan`, `lapor`, `asesmen`

### Information Commands
- `kontak`, `alamat`, `lokasi`
- Response: Info kontak BNNK

### Greeting Commands
- `halo`, `hai`, `hello`, `hi`
- Response: Welcome message

### Report Commands
- `lapor`, `aduan`, `report`
- Response: Informasi pelaporan

## Bot Response Format

### Menu Response
```
📋 Menu Layanan BNNK Surabaya:

1️⃣ 🏥 Rehabilitasi Medis
2️⃣ 🗣️ Konseling & Terapi
3️⃣ 🧪 Tes Urine Narkoba
4️⃣ 📚 Penyuluhan P4GN
5️⃣ 📢 Pelaporan Tindak Pidana
6️⃣ 📋 Asesmen & Diagnostik

Ketik nama layanan atau nomor untuk info detail.
Contoh: ketik 1 atau rehabilitasi
```

### Service Detail Response
```
🏥 Rehabilitasi Medis

📋 Layanan rehabilitasi medis untuk pecandu narkoba...

📞 Kontak: (031) 8433-456 / WA: 0811-234-567
⏰ Jadwal: Senin-Jumat: 08:00-16:00 WIB
📝 Syarat: KTP, KK, Surat rujukan dokter...

Ketik menu untuk kembali ke menu utama.
```

## Error Handling

### Webhook Verification Failed
```http
HTTP 403 Forbidden
"Verification failed"
```

### Invalid Message Format
```http
HTTP 500 Internal Server Error
{
  "error": "Internal server error"
}
```

### Database Error
- Bot akan return default response
- Error akan tercatat di log

## Security Features

1. **Webhook Verification**: Semua request WhatsApp diverifikasi
2. **Input Sanitization**: Semua input user dibersihkan
3. **Rate Limiting**: Siap untuk implementasi
4. **Error Logging**: Semua error tercatat
5. **Request Validation**: Format pesan divalidasi

## Development Testing

### Test Interface
- URL: `/test-bot.html`
- Interactive chat interface
- Quick action buttons
- Real-time response simulation

### Admin Panel
- URL: `/admin.html`
- Bot statistics monitoring
- Configuration checker
- Log viewer interface

### Status Checker
```bash
php artisan bot:status
```

## Deployment Notes

### Production Requirements
1. **SSL Certificate** (mandatory for webhook)
2. **Public domain** accessible from internet
3. **Environment variables** properly configured
4. **Database** setup and migrated
5. **Caching** enabled for performance

### Meta WhatsApp Setup
1. Create Business App at developers.facebook.com
2. Add WhatsApp product
3. Configure webhook URL: `https://yourdomain.com/api/whatsapp/webhook`
4. Set verify token: `bnnk_surabaya_2024_verify_token`
5. Subscribe to messages webhook

### Environment Variables
```env
WHATSAPP_VERIFY_TOKEN=bnnk_surabaya_2024_verify_token
WHATSAPP_ACCESS_TOKEN=your_permanent_access_token
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
WHATSAPP_APP_ID=your_app_id
WHATSAPP_APP_SECRET=your_app_secret
```
