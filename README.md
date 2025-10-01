# BNNK Surabaya WhatsApp Bot 🤖

Bot WhatsApp untuk layanan informasi BNNK Surabaya yang dibuat dengan Laravel.

## 🚀 Fitur Utama

- ✅ **Informasi Layanan Lengkap** - 6 layanan utama BNNK Surabaya
- ✅ **Respons Otomatis 24/7** - Bot selalu siap melayani
- ✅ **Session Management** - Melacak percakapan pengguna
- ✅ **Logging Komprehensif** - Semua percakapan tercatat
- ✅ **Admin Dashboard** - Monitor dan analitik
- ✅ **Multi-keyword Support** - Deteksi berbagai kata kunci Indonesia

## 📋 Layanan BNNK yang Tersedia

1. 🏥 **Rehabilitasi Medis** - Program rawat inap & rawat jalan
2. 🗣️ **Konseling & Terapi** - Konseling psikologi individual & kelompok  
3. 🧪 **Tes Urine Narkoba** - Screening untuk individu & instansi
4. 📚 **Penyuluhan P4GN** - Sosialisasi ke sekolah, kampus, instansi
5. 📢 **Pelaporan Tindak Pidana** - Laporan anonim dengan hotline 24 jam
6. 📋 **Asesmen & Diagnostik** - Evaluasi komprehensif

## 🛠️ Quick Setup

### 1. Install Dependencies
```bash
composer install
```

### 2. Setup Database
```bash
php artisan migrate
php artisan db:seed --class=BnnkServiceSeeder
```

### 3. Configure WhatsApp (.env)
```env
WHATSAPP_VERIFY_TOKEN=bnnk_surabaya_2024_verify_token
WHATSAPP_ACCESS_TOKEN=your_access_token_here
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id_here
```

### 4. Start Server
```bash
php artisan serve
```

## 🔗 API Endpoints

- **Webhook**: `/api/whatsapp/webhook` - For Meta WhatsApp
- **Test**: `/api/test` - Check bot status  
- **Admin**: `/admin/dashboard` - Bot statistics
- **Logs**: `/admin/logs` - Conversation logs

## 💬 Bot Commands

| Command | Response |
|---------|----------|
| `menu`, `layanan` | Show services menu |
| `1-6` or service name | Service details |
| `kontak`, `alamat` | BNNK contact info |
| `lapor`, `aduan` | Reporting information |
| `halo`, `hai` | Welcome greeting |

## 📱 WhatsApp Business Setup

1. **Meta for Developers**: https://developers.facebook.com/
2. **Create Business App** → Add WhatsApp Product
3. **Webhook URL**: `https://yourdomain.com/api/whatsapp/webhook`
4. **Verify Token**: `bnnk_surabaya_2024_verify_token`

## 🚀 Deployment Ready

- **SSL Required** for webhook
- **Public domain** needed
- **Tested** with Indonesian hosting providers
- **Production optimized** with caching

## 📊 Features

### Admin Dashboard
- Real-time statistics
- Popular services tracking  
- User engagement metrics
- Conversation analytics

### Logging System
- Complete conversation history
- User session tracking
- Error monitoring
- Performance metrics

## 🔒 Security Features

- Webhook verification
- Input sanitization  
- Rate limiting ready
- Error handling
- Request validation

## 📞 BNNK Surabaya Contact

- **Address**: Jl. Raya Gubeng No. 6, Gubeng, Surabaya
- **Phone**: (031) 8433-456
- **Email**: bnnksby@bnn.go.id
- **Hotline**: 184 (24 jam)

---

**© 2025 BNNK Surabaya WhatsApp Bot - Melayani Masyarakat 24/7** 🇮🇩

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
