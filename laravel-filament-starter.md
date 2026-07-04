# Laravel Sail + Filament Setup Guide

Step-by-step guide to run this project with Docker (Laravel Sail) and install Filament admin panel.

---

## 1. Install Laravel Sail

Sail is already in `composer.json` as a dev dependency. If it's not installed yet:

```bash
composer require laravel/sail --dev
```

## 2. Publish Docker Configuration

Run the sail installer to generate `docker-compose.yml`:

```bash
php artisan sail:install
```

When prompted, pick the services you need. For this project, select:
- **mysql** (database)
- **redis** (cache/session, optional)

This will:
- Create `docker-compose.yml` in your project root
- Update `.env` with Docker service hostnames (e.g. `DB_HOST=mysql`)

## 3. Start Docker Containers

```bash
./vendor/bin/sail up -d
```

- `-d` = detached mode (runs in background, doesn't lock your terminal)
- First run takes a few minutes to build the Docker images
- The app is accessible at **http://localhost** (not localhost:8000)

To stop containers:

```bash
./vendor/bin/sail down
```

## 4. Optional: Add Sail Alias

To avoid typing `./vendor/bin/sail` every time, add this alias to your `~/.zshrc` or `~/.bashrc`:

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Then reload your shell:

```bash
source ~/.zshrc
```

Now you can just type `sail up -d`, `sail artisan migrate`, etc. Make sure you are inside the project directory first — the alias looks for `vendor/bin/sail` in the current folder.

## 5. Run Database Migrations

```bash
sail artisan migrate
```

This creates all the tables your app needs (users, sessions, jobs, etc.).

If you want to re-run from scratch:

```bash
sail artisan migrate:fresh
```

## 6. Generate Application Key

```bash
sail artisan key:generate
```

Usually already set up, but run this if `APP_KEY` is empty in `.env`.

## 7. Install Node Dependencies & Build Assets

```bash
sail npm install
sail npm run build
```

For development (hot reload):

```bash
sail npm run dev
```

## 8. Install Filament

### 8a. Install the Filament package

```bash
sail composer require filament/filament
```

### 8b. Publish Filament assets

```bash
sail artisan filament:install
```

This only publishes JS/CSS assets to `public/`. It does NOT create the admin panel yet.

### 8c. Create admin panel

```bash
sail artisan make:filament-panel admin
```

When prompted:
- Enter admin panel ID (e.g. `admin`)

This creates:
- Panel provider in `app/Providers/Filament/AdminPanelProvider.php`
- Admin panel routes at `/admin`

> **Important:** Filament v4 does NOT enable the login page by default. You must manually add `->login()` to the panel configuration in `app/Providers/Filament/AdminPanelProvider.php`. Without this, you will get `Route [login] not defined` error when accessing `/admin`.

### 8d. Create admin user

```bash
sail artisan make:filament-user
```

When prompted, fill in:
- Name
- Email
- Password

### 8e. Run Migrations Again

Filament adds its own migration for the admin panel tables:

```bash
sail artisan migrate
```

### 8f. Create a Filament Resource (optional)

To manage a model from the admin panel:

```bash
sail artisan make:filament-resource Post
```

This generates a resource file in `app/Filament/Resources/` that you can customize.

## 9. Access the Admin Panel

Open your browser and go to:

```
http://localhost/admin
```

Log in with the admin credentials you created during `make:filament-user`.

---

## Common Sail Commands Reference

| Command | Description |
|---------|-------------|
| `sail up -d` | Start containers in background |
| `sail down` | Stop containers |
| `sail shell` | Open bash shell inside app container |
| `sail artisan <cmd>` | Run artisan commands inside container |
| `sail composer <cmd>` | Run composer commands inside container |
| `sail npm <cmd>` | Run npm commands inside container |
| `sail logs` | View container logs |
| `sail restart` | Restart all containers |

---

## Troubleshooting

**Port conflict (3306 already in use):**
If you have a local MySQL running, edit `docker-compose.yml` and change the host port mapping:
```yaml
ports:
  - '3307:3306'  # maps local 3307 to container 3306
```
Then update `DB_PORT=3307` in `.env`.

**Session table not found:**
This project uses `SESSION_DRIVER=database`. Make sure you've run `sail artisan migrate` so the `sessions` table exists.

**Permission issues inside container:**
```bash
sail artisan storage:link
sail composer install
```

**Rebuild containers after changing Dockerfile:**
```bash
sail down
sail build --no-cache
sail up -d
```
