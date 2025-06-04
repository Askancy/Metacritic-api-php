# 🎮 Askancy Metacritic API PHP

**Level up your apps** with real-time Metacritic scores using this lightweight PHP package.  
No API keys, no rate limits — just smart scraping and structured JSON output. 🧠⚡

---

## 📦 Install & Deploy

Install it via Composer and get your first score in less than 60 seconds:

```bash
composer require askancy/metacritic-api-php
````

---

## 🕹️ How to Play (Usage)

```php
require 'vendor/autoload.php';

use Askancy\Metacritic\MetacriticScraper;
use Askancy\Metacritic\Exceptions\MetacriticException;

$scraper = new MetacriticScraper();

try {
    $result = $scraper->fetch('elden-ring'); // Use the Metacritic slug
    echo json_encode($result, JSON_PRETTY_PRINT);
} catch (MetacriticException $e) {
    echo "💥 Error: " . $e->getMessage();
}
```

🧠 **Pro Tip:** You can pass any valid slug like `'god-of-war-ragnarok'`, `'cyberpunk-2077'`, `'final-fantasy-vii-remake'`, etc.

---

## 🧾 Sample JSON Response

```json
{
  "slug": "elden-ring",
  "url": "https://www.metacritic.com/game/elden-ring",
  "score": "96"
}
```

* `slug`: Slug used to build the URL
* `url`: Full Metacritic link to the game page
* `score`: Metacritic metascore (0-100)

---

## 🧪 Unit Testing (PHPUnit)

Run the full test suite to validate your setup:

```bash
composer install
vendor/bin/phpunit tests/
```

✅ Includes:

* Score presence and format check
* Proper exception handling on 404 pages
* JSON serialization test

---

## 🛠️ Directory Structure

```
metacritic-api-php/
├── src/
│   ├── MetacriticScraper.php        # Main class
│   └── Exceptions/
│       └── MetacriticException.php  # Custom error
├── tests/
│   └── MetacriticScraperTest.php    # PHPUnit test
├── composer.json
├── README.md
```

---

## 🧙‍♂️ Advanced Features

* ✅ No API key required
* ⚠️ Graceful error handling (timeouts, 404s)
* 🧩 Easily extendable to retrieve more metadata (e.g., platforms, release date)
* 🕵️‍♀️ Smart fallback: if JSON-LD fails, uses HTML metascore node

---

## 🧠 Game Dev Friendly

This package is perfect for:

* Game databases 🗃️
* Gaming communities 🧑‍🤝‍🧑
* Game recommendation engines 🤖
* Gamified profiles or dashboards 📊

---

## 📜 License

This package is licensed under the [MIT License](LICENSE), with one twist:

> ❌ Redistribution and reselling is NOT allowed.
> 🔁 Contributions and improvements are always welcome.

---

## 🔗 Credits & Contact

Made with ❤️ by [Askancy](https://github.com/askancy)
For support, bugs or PRs: GitHub Issues

---

> 💬 *"Always check the score, before you hit Play."* 🎮
