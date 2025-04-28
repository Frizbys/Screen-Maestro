# Screen-Maestro
ScreenMaestro: Lightweight Open-Source Digital Signage Manager (PHP + MySQL).  Manage screens, upload media, and control digital signage easily — no subscriptions, no bloat.

---

## ✨ Features

- 🎯 Manage multiple screens from a clean dashboard
- 📷 Upload and assign images/videos (JPG, PNG, WebP, MP4, WebM)
- ⚡ Pure PHP + MySQL (lightweight, fast, no heavy frameworks)
- 📱 Mobile and desktop admin friendly
- 🔒 100% Self-Hosted — you own your server, your screens, your system
- 💵 No subscriptions, fees, or "premium" features
- 🛡️ Open-source and community-driven development

---

## 🚀 Installation

1. Clone or download this repository.
2. Create a MySQL database on your server.
3. Import the provided SQL schema (`database/schema.sql`) into your database.
4. Copy `config.sample.php` to `config.php` and fill in your database credentials.
5. Set correct permissions on the `/public/uploads/` folder:
   ```bash
   chmod 755 public/uploads/
