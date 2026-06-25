# Form Builder Pro

A drag-and-drop form builder plugin for [GetSimpleCMS-CE](https://getsimple-ce.ovh), with mail() and SMTP. (SQLite3 required).

## Features

### Form Building
- Drag-and-drop canvas with live field reordering
- **Field types:** Text, Textarea, Email, Phone, Number, Dropdown, Radio Group, Checkbox Group, File Upload, Date, Time, Header, Paragraph
- Per-field properties: label, name, placeholder, required, help text (tooltip), CSS class, type/subtype
- Radio & Checkbox: inline display, toggle style (checkbox), "Other" option with free-text input
- Paragraph fields support HTML (links, formatting)

### Email Delivery
- **PHP `mail()`** or **SMTP** selectable per form
- PHPMailer for SMTP (TLS/STARTTLS/SSL)
- Reply-To: designate any email field as the reply-to address
- File attachments via SMTP
- Download links for uploaded files included in all emails
- Test email button with diagnostics

### File Uploads
- Per-field allowed file types (configurable, defaults to common document/image types)
- Per-field maximum file size (MB)
- Token-based public download endpoint — no login required
- Files manager tab in admin: view, size, delete
- `.htaccess` protection on upload directory

### Spam Protection
- **Honeypot** — hidden field, invisible to users
- **Time-based check** — configurable minimum response time
- **Cloudflare Turnstile** — invisible CAPTCHA
- **hCaptcha** — privacy-friendly checkbox CAPTCHA
- **Google reCAPTCHA v2** — "I'm not a robot" checkbox
- **Google reCAPTCHA v3** — invisible, score-based with configurable threshold

### Submissions
- All submissions stored in SQLite
- Admin submissions viewer per form
- File download links in submissions modal

### Embedding
- **Shortcode:** `[formbuilderpro slug="contact"]`
- **Template tag:** `<?php get_FormBuilderPro('contact'); ?>`
- Embed codes auto-generated in the builder

### Internationalisation
- Admin canvas language follows the GS admin user's language setting
- Bundled languages: **English, Spanish, French, German, Polish**
- Add more by dropping a `.lang` file in `assets/lang/`
- Plugin UI strings fully translatable via GS i18n

---

## Requirements

- GetSimpleCMS-CE
- PHP 7.4+
- SQLite3 PHP extension
- Apache 2.4+ (or equivalent)

---

## Installation

1. Copy `FormBuilderPro.php` & the `FormBuilderPro/` folder to your `plugins/` folder.
2. Activate the plugin in the GS admin panel under **Plugins**.
3. Access the plugin via the **Themes** sidebar menu.

---

## Data Storage

The plugin uses a SQLite database at `data/other/FormBuilderPro.db` with three tables:

| Table | Contents |
|---|---|
| `fbp_forms` | Form definitions (fields JSON, settings JSON) |
| `fbp_submissions` | Submitted form data |
| `fbp_upload_tokens` | Permanent download tokens for uploaded files |

Uploaded files are stored in `data/other/fbp_uploads/` with a `.htaccess` deny rule applied automatically on first use.

---

## Embedding Forms

### Shortcode (in page content)
```
[formbuilderpro slug="contact"]
[formbuilderpro id="1"]
```

### Template tag (in theme PHP)
```php
<?php get_FormBuilderPro('contact'); ?>
<?php get_FormBuilderPro(1); ?>
```

---

## Adding Languages

1. Copy `en-US.lang` file from `plugins/FormBuilderPro/assets/lang/`, using it as a template.
3. The canvas will automatically use it for any admin user with that language set in GS

The plugin UI strings (menus, settings labels) are translated separately via the GS i18n system. Add a corresponding `plugins/FormBuilderPro/lang/` file using `en_US.php` as a template.

---

## Credits

- [risingisland](https://github.com/risingisland) — Plugin author
- [kevinchappell/formBuilder](https://github.com/kevinchappell/formBuilder) — drag-and-drop form builder library
- [PHPMailer](https://github.com/PHPMailer/PHPMailer) — SMTP email delivery
- [GetSimpleCMS-CE](https://getsimple-ce.ovh) — CMS platform

---
