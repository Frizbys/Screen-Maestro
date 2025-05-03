# Screen Maestro Installation

Welcome to Screen Maestro — the simple, self-hosted signage manager.

## 🚀 Quick Start

1. **Extract the ZIP contents** directly into your `public_html` or web root.  
   _Don't bury it in a subfolder — everything should land in the root unless you know what you're doing._

2. **Visit the setup tool in your browser**:  
   If you extracted into the root:
   ```
   http://www.yourdomain.com/setup/index.html
   ```
   If you put it in a subfolder (like `/signage/`), use:
   ```
   http://www.yourdomain.com/signage/setup/index.html
   ```

   📌 You’ll need to adjust file paths in `config.php` and URLs accordingly if you go the subfolder route.

3. **Set permissions on the `uploads` folder**:  
   - Recommended: `755`  
   - If you have permission errors, try `777` — _but be aware this is less secure._

## 🔒 Final Step

After setup is complete, **delete the entire `/setup` folder** to protect your server.

---

Need help? Open an issue on GitHub or yell at the sky. Up to you.

– Mr. Frizby
