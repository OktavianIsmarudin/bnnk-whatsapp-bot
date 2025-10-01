# 🚀 Deploy BNNK WhatsApp Bot ke Railway.app (GRATIS)

Panduan lengkap untuk deploy WhatsApp bot BNNK Surabaya ke Railway.app menggunakan akun GitHub secara gratis.

## 📋 Prerequisites

- ✅ Akun GitHub
- ✅ Token WhatsApp Business API dari Meta
- ✅ Project Laravel sudah siap

## 🎯 Step-by-Step Deployment

### Step 1: Setup GitHub Repository

1. **Buat repository baru di GitHub:**
   - Buka [github.com](https://github.com)
   - Klik "New repository"
   - Nama: `bnnk-whatsapp-bot`
   - Set sebagai Public
   - Jangan centang "Add README" (sudah ada)

2. **Push project ke GitHub:**
```bash
git init
git add .
git commit -m "Initial commit - BNNK WhatsApp Bot"
git branch -M main
git remote add origin https://github.com/USERNAME/bnnk-whatsapp-bot.git
git push -u origin main
```

### Step 2: Deploy ke Railway.app

1. **Buka Railway.app:**
   - Kunjungi [railway.app](https://railway.app)
   - Klik "Login" → "Login with GitHub"
   - Authorize Railway untuk akses GitHub

2. **Create New Project:**
   - Klik "Deploy from GitHub repo"
   - Pilih repository `bnnk-whatsapp-bot`
   - Railway akan otomatis detect Laravel

3. **Tambah MySQL Database:**
   - Di dashboard project, klik "New"
   - Pilih "Database" → "MySQL"
   - Database akan otomatis terhubung

### Step 3: Configure Environment Variables

Di Railway dashboard → Variables, tambahkan:

```env
# Laravel Configuration
APP_NAME=BNNK Surabaya WhatsApp Bot
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta

# Database (akan otomatis terisi oleh Railway)
DB_CONNECTION=mysql
DB_HOST=${{ MYSQL_HOST }}
DB_PORT=${{ MYSQL_PORT }}
DB_DATABASE=${{ MYSQL_DATABASE }}
DB_USERNAME=${{ MYSQL_USER }}
DB_PASSWORD=${{ MYSQL_PASSWORD }}

# WhatsApp Business API
WHATSAPP_VERIFY_TOKEN=bnnk_surabaya_2024_verify
WHATSAPP_ACCESS_TOKEN=EAAStbju0LAABPsZC87mpvZAZCM5aoxyZBb1scZBs7dK1opI9Inmb1PvlENsnlDRDPdVvy3fGoqX8OEGBcy8JgYHO4Xqbfc3oaGAtMGzpZAe1TkZAqeaJ1iAhYbOgWJrrdszoZA6YvXru6tl4S2yZB3IkQOMZAjnTPqYgJyWt6TZAHWdzd9MaHfRLrVllXz21XcL7DirA87lQhlcDsOggDkkhpwUckrZBIegU6fV14jlK0hwi7AZDZD
WHATSAPP_PHONE_NUMBER_ID=816672864861761
WHATSAPP_BUSINESS_ACCOUNT_ID=1758630014848323

# BNNK Information
BNNK_NAME=BNNK Surabaya
BNNK_ADDRESS=Jl. Raya Gubeng No. 6, Gubeng, Surabaya
BNNK_PHONE=(031) 8433-456
BNNK_EMAIL=bnnksby@bnn.go.id
BNNK_WEBSITE=https://surabaya.bnn.go.id
```

### Step 4: Deploy & Monitor

1. **Tunggu deployment selesai** (3-5 menit)
2. **Cek logs** di Railway dashboard
3. **Dapatkan URL aplikasi**: `https://bnnk-whatsapp-bot-production.up.railway.app`

### Step 5: Configure WhatsApp Webhook

1. **Buka Meta Developer Console:**
   - [developers.facebook.com](https://developers.facebook.com)
   - Pilih aplikasi WhatsApp Business

2. **Update Webhook:**
   - Webhook URL: `https://your-app.railway.app/api/whatsapp/webhook`
   - Verify Token: `bnnk_surabaya_2024_verify`
   - Subscribe to: `messages`

3. **Test Webhook:**
   - Klik "Verify and Save"
   - Harus berhasil ✅

## 🎉 Testing

1. **Kirim pesan "menu" ke nomor WhatsApp Bot**
2. **Bot harus merespons dengan menu layanan BNNK**
3. **Cek logs di Railway dashboard**

## 📊 Railway Free Tier

- ✅ **500 jam runtime/bulan** (cukup untuk bot 24/7)
- ✅ **1GB RAM & Storage**
- ✅ **MySQL database gratis**
- ✅ **Custom domain support**
- ✅ **SSL certificate otomatis**

## 🔧 Troubleshooting

### Deployment Gagal
```bash
# Cek logs di Railway dashboard
# Pastikan semua dependencies terinstall
# Verify environment variables
```

### Webhook Validation Gagal
```bash
# Pastikan URL benar: https://your-app.railway.app/api/whatsapp/webhook
# Verify token harus sama: bnnk_surabaya_2024_verify
# Aplikasi harus sudah running
```

### Database Error
```bash
# Pastikan MySQL service sudah running
# Check database environment variables
# Run migration manual via Railway console
```

## 📞 Support

- **Email**: bnnksby@bnn.go.id
- **GitHub Issues**: [Link to repository issues]
- **WhatsApp**: (031) 8433-456

---

**🎯 Total waktu deployment: ~10 menit**
**💰 Biaya: GRATIS selamanya dengan GitHub account**