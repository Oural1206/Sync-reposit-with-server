# 🔌 Sync reposit with server

### 🎖 License
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## 📝 Description
> This crons task in php allows to synchronize a private branch on github with your server.

## 🧱 Setup
To get all the functions you just have to insert this line in your .php page and add <a href="https://github.com/Oural1206/Sync-reposit-with-server/blob/main/config.json">config.json</a> between.
```php
<?php include("https://raw.githubusercontent.com/Oural1206/Sync-reposit-with-server/main/sync.php") ?>
```
>⚠️ Warning, you must activate <a href="https://www.php.net/manual/fr/filesystem.configuration.php#ini.allow-url-include">allow-url-include</a> in the php.init configuration file.
> *(<a href="https://github.com/Oural1206/Sync-reposit-with-server/blob/main/sync.php">sync.php</a> include <a href="https://github.com/Oural1206/php-functions">Oural1206/php-functions</a> repository)*
