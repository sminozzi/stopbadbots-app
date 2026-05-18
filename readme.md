````markdown
# Stop Bad Bots App

Stop Bad Bots is a standalone PHP application designed to protect websites and servers against malicious bots, fake crawlers, suspicious IPs, spam referers, HTTP tools and abusive traffic.

Bad bots consume bandwidth, overload servers, slow down websites, steal content and search for vulnerabilities to compromise your infrastructure.

The application works with non-WordPress websites and can be integrated into almost any PHP-based site.

For WordPress users, please visit:

https://stopbadbots.com

---

# Requirements

To run Stop Bad Bots App, your server should have:

- Linux Server
- PHP 7.x or newer
- MySQLi enabled
- PHP Sessions enabled
- PHP Curl enabled
- PHP Zip enabled
- Minimum 128MB PHP memory

---

# Installation

## 1. Download

Download the Non-WordPress version from:

https://stopbadbots.com

---

## 2. Upload

Upload the entire folder to your server root.

Example:

```text
https://YourSite.com/stopbadbots/
````

---

## 3. Run Installer

Open:

```text
https://YourSite.com/stopbadbots/install
```

and follow the installation wizard.

---

# Important: After Install

To activate protection, you must include Stop Bad Bots in your main PHP page.

If necessary, rename:

```text
index.html
```

to:

```text
index.php
```

Then add this at the TOP of your main page:

```php
<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '/stopbadbots/');
require_once('stopbadbots/stopbadbots.php');
?>
```

After that, nothing should appear visually on your page.

---

# Startup Guide

After installation:

Open:

```text
https://YourSite.com/stopbadbots/
```

and configure the application.

## Recommended First Steps

### 1. Enable Protection

Go to:

```text
Setup => General Settings
```

and enable blocking options.

---

### 2. Manage Bad Bots

Go to:

```text
Tables => Bad Bots
```

You can:

* enable/disable bots
* add custom bots
* monitor blocked bots

Be careful with generic terms like:

```text
bot
```

because it may block legitimate crawlers like Googlebot.

---

### 3. Manage Bad IPs

Go to:

```text
Tables => Bad IP
```

and add suspicious IP addresses.

---

### 4. Manage Bad Referers

Go to:

```text
Tables => Bad Refer
```

---

### 5. Configure Rate Limiting

Go to:

```text
Setup => Limit Bots Visits
```

and limit excessive visits.

---

### 6. Configure HTTP Tools Protection

Go to:

```text
Setup => Block HTTP Tools
```

to block tools like:

* curl
* wget
* scanners
* automated HTTP clients

---

### 7. Configure Whitelist

Go to:

```text
Setup => WhiteList
```

and whitelist:

* IPs
* strings
* bots

---

### 8. Configure Notifications

Go to:

```text
Setup => Email and Notifications
```

to receive alerts about:

* bot attempts
* firewall blocks
* suspicious activity

---

# Important Notes

Not all bots are malicious.

During the first days, frequently review:

* Bad Bots table
* Bad IP table
* statistics dashboard

Some legitimate services may use:

* blank user agents
* unusual crawlers
* non-standard requests

Examples:

* Telegram
* WhatsApp
* Applebot
* LinkedIn
* Twitterbot
* FacebookBot
* Qwant
* SkypeUriPreview

---

# Dashboard

The dashboard provides:

* blocked bots statistics
* top blocked IPs
* referers
* charts
* protection level
* traffic analysis

---

# How Protection Works

When a bot matches:

* User-Agent
* IP
* Referer
* HTTP tool detection

the application returns:

```text
403 Forbidden
```

preventing:

* bandwidth abuse
* content scraping
* vulnerability scans
* automated attacks

---



# Updates

Enable automatic updates in Settings.

The system can receive:

* software updates
* database updates
* bot definitions

---

# Support

Documentation, guides and troubleshooting:

[https://stopbadbots.com/help2/](https://stopbadbots.com/help2/)

Support:

[https://billminozzi.com/dove/](https://billminozzi.com/dove/)

---

# Author

Bill Minozzi

[https://stopbadbots.com](https://stopbadbots.com)

```
```