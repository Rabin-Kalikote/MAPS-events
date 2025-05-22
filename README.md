<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# MAPS Events

MAPS Events is a Laravel web application for managing and visualizing events on a college campus map. Users can view, search, and explore events, while administrators can add, edit, and delete events with secure access.

## Features

- **Interactive College Map:**
  - Events are displayed as markers on a responsive college map.
  - Event positions are stored as percentages, so markers are always accurate regardless of map size.
- **Event Management:**
  - Add, edit, and delete events (admin only).
  - Upload or link event thumbnails.
  - Set event title, description, date, and status (upcoming, happened, cancelled).
- **Search & Filter:**
  - Search events by title or description.
  - Filter events by status using tabs.
- **Admin Authentication:**
  - Admin actions require a password (stored in frontend for demo purposes).
- **Responsive Design:**
  - Works well on desktop and mobile devices.

## Tech Stack
- Laravel (PHP)
- Blade templates
- Bootstrap 5
- SQLite (default, can be changed)

## Getting Started

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Rabin-Kalikote/MAPS-events.git
   cd MAPS-events
   ```
2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```
3. **Set up environment:**
   - Copy `.env.example` to `.env` and adjust settings if needed.
   - Generate app key:
     ```bash
     php artisan key:generate
     ```
4. **Run migrations:**
   ```bash
   php artisan migrate
   ```
5. **Build frontend assets:**
   ```bash
   npm run build
   ```
6. **Start the server:**
   ```bash
   php artisan serve
   ```
7. **Access the app:**
   - Visit [http://localhost:8000](http://localhost:8000)

## Admin Access
- Click **Admin Sign In** and enter the password: `mapsadmin123` (for demo/testing only).

## Credits
- Built by Rabin Kalikote and Shubham Shrestha for the College of Idaho.

## License
MIT
