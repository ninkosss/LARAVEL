<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 📚 **Покрокова інструкція по створенню та налаштуванню проекту Laravel**

## 🎯 **Вступ**

Ця інструкція допоможе вам створити повноцінний веб-проект на Laravel з використанням архітектури MVC (Model-View-Controller). Ми створимо проект для управління іграми з усіма необхідними компонентами.

## 📋 **Що таке MVC та інші елементи:**

### **🏗️ MVC (Model-View-Controller) Архітектура:**
- **Model (Модель)** - представляє дані та бізнес-логіку додатку. Відповідає за взаємодію з базою даних.
- **View (Представлення/Шаблон)** - відповідає за відображення даних користувачу (HTML, CSS, JS).
- **Controller (Контролер)** - обробляє запити користувача, взаємодіє з моделлю та передає дані у view.

### **🛠️ Додаткові елементи:**
- **Migration (Міграція)** - PHP файли для створення/зміни структури бази даних
- **Factory (Фабрика)** - генерує тестові дані для моделей
- **Seeder (Сідер)** - заповнює базу даних тестовими даними
- **Route (Маршрут)** - визначає URL адреси та які контролери їх обробляють

---

## 🚀 **Крок 1: Встановлення Laravel**

### **Передумови:**
- PHP 8.1 або вище
- Composer (менеджер пакетів PHP)
- MySQL або SQLite

### **Інструкція встановлення:**

```bash
# Встановіть Laravel через Composer у директорію library
composer create-project laravel/laravel library

# Перейдіть в директорію проекту
cd library

# Налаштуйте файл .env
cp .env.example .env

# Згенеруйте ключ додатку
php artisan key:generate

# Налаштуйте базу даних в .env файлі
DB_CONNECTION=sqlite
DB_DATABASE=database.sqlite
```

---

## ⚙️ **Крок 2: Початкове налаштування**

### **Налаштування бази даних:**
```bash
# Створіть файл бази даних (якщо використовуєте SQLite)
touch database/database.sqlite

# Запустіть міграції (створять базові таблиці)
php artisan migrate
```

### **Запуск сервера:**
```bash
# Запустіть локальний сервер розробки
php artisan serve

# Сервер буде доступний на http://localhost:8000
```

---

## 🎮 **Крок 3: Реалізація MVC для проекту "Ігри"**

### **Крок 3.1: Створення Моделі (Model)**

**📖 Визначення:** Модель - це PHP клас, що представляє таблицю в базі даних та містить бізнес-логіку для роботи з даними.

```bash
# Створіть модель Game
php artisan make:model Game
```

**Код моделі** (`app/Models/Game.php`):
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'genre',
        'release_year',
    ];
}
```

### **Крок 3.2: Створення Міграції (Migration)**

**📖 Визначення:** Міграція - це PHP файл, що містить інструкції для створення або зміни структури бази даних.

```bash
# Створіть міграцію для таблиці games
php artisan make:migration create_games_table
```

**Код міграції** (`database/migrations/XXXX_XX_XX_XXXXXX_create_games_table.php`):
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('genre');
            $table->year('release_year');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
```

```bash
# Запустіть міграцію
php artisan migrate
```

### **Крок 3.3: Створення Фабрики (Factory)**

**📖 Визначення:** Фабрика - це клас, що генерує фейкові тестові дані для моделей, використовуючи бібліотеку Faker.

```bash
# Створіть фабрику для моделі Game
php artisan make:factory GameFactory
```

**Код фабрики** (`database/factories/GameFactory.php`):
```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'genre' => fake()->randomElement(['Action', 'RPG', 'Strategy', 'Adventure', 'Simulation']),
            'release_year' => fake()->year(),
        ];
    }
}
```

### **Крок 3.4: Створення Сідера (Seeder)**

**📖 Визначення:** Сідер - це клас, що заповнює базу даних тестовими даними через фабрики.

**Змініть файл** (`database/seeders/DatabaseSeeder.php`):
```php
<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Game; // Додайте цей імпорт
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Створіть тестового користувача
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Створіть 10 тестових ігор
        Game::factory(10)->create();
    }
}
```

```bash
# Запустіть сідер
php artisan db:seed
```

### **Крок 3.5: Створення Контролера (Controller)**

**📖 Визначення:** Контролер - це клас, що обробляє HTTP запити, взаємодіє з моделями та передає дані у view.

```bash
# Створіть контролер GameController
php artisan make:controller GameController
```

**Код контролера** (`app/Http/Controllers/GameController.php`):
```php
<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('games.index', compact('games'));
    }
}
```

### **Крок 3.6: Створення Шаблону (View)**

**📖 Визначення:** View (шаблон) - це файл, що містить HTML розмітку та відображає дані користувачу.

```bash
# Створіть директорію для view
mkdir resources/views/games

# Створіть файл index.blade.php
```

**Код шаблону** (`resources/views/games/index.blade.php`):
```html
<!DOCTYPE html>
<html>
<head>
    <title>Ігри</title>
</head>
<body>
    <h1>Список ігор</h1>
    <ul>
        @foreach($games as $game)
            <li>
                <strong>{{ $game->name }}</strong> -
                Жанр: {{ $game->genre }} -
                Рік: {{ $game->release_year }}
            </li>
        @endforeach
    </ul>
</body>
</html>
```

### **Крок 3.7: Створення Маршруту (Route)**

**📖 Визначення:** Маршрут визначає URL адресу та який контролер/метод буде обробляти запит.

**Змініть файл** (`routes/web.php`):
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('welcome');
});

// Додайте цей маршрут для сторінки ігор
Route::get('/games', [GameController::class, 'index']);
```

---

## ✅ **Перевірка результату**

### **Запустіть сервер:**
```bash
php artisan serve
```

### **Перевірте роботу:**
- **Головна сторінка:** `http://localhost:8000/`
- **Сторінка ігор:** `http://localhost:8000/games`

На сторінці `/games` ви побачите список 10 тестових ігор з випадковими назвами, жанрами та роками випуску.

---

## 🎯 **Підсумок**

Ви створили повноцінний MVC додаток Laravel з:
- ✅ Моделлю для роботи з даними
- ✅ Міграцією для структури БД
- ✅ Фабрикою для генерації тестових даних
- ✅ Сідером для заповнення БД
- ✅ Контролером для обробки запитів
- ✅ Шаблоном для відображення даних
- ✅ Маршрутом для доступу до сторінки

**Все виконано в коді та протестовано!** 🚀

---

## 📊 **СТАТУС ВИКОНАННЯ:**

| Елемент | Статус | Файл |
|---------|--------|------|
| **Модель (Model)** | ✅ Виконано | `app/Models/Game.php` |
| **Міграція (Migration)** | ✅ Виконано | `database/migrations/..._create_games_table.php` |
| **Фабрика (Factory)** | ✅ Виконано | `database/factories/GameFactory.php` |
| **Сідер (Seeder)** | ✅ Виконано | `database/seeders/DatabaseSeeder.php` |
| **Контролер (Controller)** | ✅ Виконано | `app/Http/Controllers/GameController.php` |
| **Шаблон (View)** | ✅ Виконано | `resources/views/games/index.blade.php` |
| **Маршрут (Route)** | ✅ Виконано | `routes/web.php` |

---

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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
