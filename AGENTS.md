# Luminary SV - Especificaciones Técnicas del Proyecto

## 1. Visión General
Transformación de un sitio estático (`luminarysv.com`) en una plataforma web autoadministrable (CMS) dinámica para la gestión de eventos de música electrónica (Trance/Techno).

## 2. Stack Tecnológico
*   **Framework:** Laravel 12 (PHP 8.2+).
*   **Base de Datos:** MySQL (XAMPP) — base de datos: `luminary_db`.
*   **Autenticación:** Laravel Breeze (Blade) — sesiones almacenadas en DB.
*   **Frontend Admin:** Tabler (Bootstrap 5).
*   **JS Framework:** jQuery 3.7.1.
*   **Tablas CRUD:** jQuery DataTables 1.13.7.
*   **Alertas y Confirmaciones:** SweetAlert2.
*   **Frontend Público:** Tailwind CSS 4.0 + Alpine.js 3.4.2 + Vite 7.0.
*   **Entorno Local:** Windows (XAMPP, Virtual Host `luminary.test`).

## 3. Arquitectura de Base de Datos (`luminary_db`)

### Tablas del sistema
*   **`users`**: Administradores (Breeze). Campos: id, name, email, password, email_verified_at, remember_token, timestamps.
*   **`password_reset_tokens`**, **`sessions`**, **`cache`**: Tablas estándar de Laravel.

### Tablas del dominio
*   **`djs`**: Perfiles de DJs/artistas. Campos: id, name, slug, biography, image_path, facebook_url, instagram_url, soundcloud_url, beatport_url, tiktok_url, sort_order, timestamps.
*   **`events`**: Eventos musicales. Campos: id, title, slug, description, event_date (datetime), location, image_path, external_link, is_active (boolean), timestamps.
*   **`albums`**: Álbumes fotográficos agrupados. Campos: id, title, slug, description, cover_image_path, event_id (FK nullable → events), is_active, timestamps.
*   **`galleries`**: Fotos individuales. Campos: id, title, image_path, category (enum: event/backstage/artist), event_id (nullable), album_id (FK → albums, cascade delete), timestamps.
*   **`partners`**: Sponsors/alianzas. Campos: id, name, description, logo_path, website_url, timestamps.
*   **`about_us`**: Página única (id=1). Campos: id, title, content (longtext), hero_image_path, vision, mission, timestamps.
*   **`settings`**: Configuración global key-value. Campos: id, key (unique), value, label, timestamps. Helper estático: `Setting::getValue($key, $default)`.
    *   Claves activas: `site_logo`, `admin_logo`, `home_about_image`, `hero_bg_type`, `hero_bg_path`, `hero_youtube_url`, `hero_title`, `hero_subtitle`, `hero_cta_text`, `hero_cta_link`, `contact_email`, `footer_facebook`, `footer_instagram`, `footer_tiktok`, `footer_text`.

## 4. Estructura de Rutas

### Rutas Públicas (`App\Http\Controllers\Web\`)
*   `GET /` → HomeController@index (`name: home`)
*   `GET /eventos` → EventosController@index (`name: eventos`)
*   `GET /djs` → DjsController@index (`name: djs`)
*   `GET /galeria` → GaleriaController@index (`name: galeria`)
*   `GET /nosotros` → NosotrosController@index (`name: nosotros`)
*   `GET /alianzas` → AlianzasController@index (`name: alianzas`)
*   `GET /contacto` → ContactoController@index (`name: contacto`)
*   Rutas de auth (login, register, password reset, email verification) vía `routes/auth.php`

### Rutas Admin (middleware: `auth`, `verified`) — prefijo `/admin`
*   `GET /admin/dashboard` → DashboardController@index
*   Resource: `/admin/djs` → DjController
*   Resource: `/admin/events` → EventController
*   Resource: `/admin/albums` → AlbumController
*   Resource: `/admin/gallery` → GalleryController
*   Resource: `/admin/partners` → PartnerController
*   `GET|PUT /admin/about` → AboutUsController
*   `GET|PUT /admin/settings` → SettingController

## 5. Controladores Admin (`App\Http\Controllers\Admin\`)
*   **DashboardController** — estadísticas: conteo de eventos, DJs, galería.
*   **DjController** — CRUD completo. Imágenes en `storage/app/public/djs` (maxWidth: 1200).
*   **EventController** — CRUD completo. Imágenes en `storage/app/public/events` (maxWidth: 1920).
*   **AlbumController** — CRUD completo. Imágenes en `storage/app/public/albums` (maxWidth: 1200). Relación opcional con events.
*   **GalleryController** — CRUD completo. Imágenes en `storage/app/public/gallery` (maxWidth: 1920, quality: 80). Relación con albums y events.
*   **PartnerController** — CRUD completo. Logos en `storage/app/public/partners` (maxWidth: 900, quality: 88). Soporta: jpeg, png, jpg, webp, svg.
*   **AboutUsController** — Solo index y update. Crea registro id=1 si no existe. Imagen en `storage/app/public/about` (maxWidth: 1920).
*   **SettingController** — Solo index y update. Maneja `site_logo` (600px), `admin_logo` (600px), `home_about_image` (1200px), `hero_bg_path` (1920px para imágenes, sin optimización para videos), texto plano, con limpieza de archivos anteriores.

### Servicio reutilizable
*   **`App\Services\ImageOptimizer`** — `store(UploadedFile $file, string $directory, int $maxWidth = 1920, int $quality = 82): string`
    *   Usa PHP GD nativo (sin dependencias externas).
    *   Convierte a WebP con fallback automático a JPEG si `imagewebp()` no está disponible.
    *   Redimensiona preservando aspect ratio cuando excede `maxWidth`.
    *   Preserva canal alfa (transparencia PNG).
    *   Bypass automático para SVG/GIF (almacena tal cual).
    *   Validación de tamaño relajada a `max:15360` (15 MB) en todos los controladores.

## 6. Estándares de Desarrollo
*   **Rutas Admin:** Prefijo `/admin`, protegidas por middleware `auth` + `verified`.
*   **Gestión de Archivos:** Vía `ImageOptimizer::store()` (preferido para imágenes) o `Storage::disk('public')->store()` (videos). Symlink `public/storage/` vía `php artisan storage:link`.
*   **Subdirectorios de storage:** `djs/`, `events/`, `albums/`, `gallery/`, `partners/`, `about/`, `hero/`, `settings/`.
*   **Naming:** Controladores en `App\Http\Controllers\Admin` (admin) y `App\Http\Controllers\Web` (público); Modelos en `App\Models`; Servicios en `App\Services`.
*   **Slugs:** Generados con `Str::slug()`.
*   **UX:** Toasts de SweetAlert2 para éxito/error; modales de confirmación para eliminaciones (`.delete-btn`).
*   **Tablas:** DataTables en todas las vistas de listado del admin.
*   **Idioma UI:** Español en etiquetas, mensajes y notificaciones del admin.
*   **CSS frontend público:** Tailwind CSS 4 + variables CSS de marca (`--lmn-dark`, `--lmn-navy`, `--lmn-cyan`, `--lmn-red`) + tipografía Barlow Condensed para headings.
*   **Build assets:** `npm run build` (Vite). Las clases dinámicas en Blade (ternarios, interpolación) requieren rebuild; cuando se necesite estabilidad sin rebuild se usa `style="..."` inline.

## 7. Vistas Admin (`resources/views/admin/`)
*   `dashboard.blade.php`
*   `djs/` → index, create, edit
*   `events/` → index, create, edit
*   `albums/` → index, create, edit
*   `gallery/` → index, create, edit
*   `partners/` → index, create, edit
*   `about_us/edit.blade.php`
*   `settings/index.blade.php`

Layout base admin: `layouts/admin.blade.php` (Tabler CDN, SweetAlert2, DataTables, Google Fonts Inter, sidebar con detección de ruta activa, logo dinámico desde `admin_logo` setting).

## 8. Vistas Públicas (`resources/views/public/`)
*   `home.blade.php` — Hero (imagen/video local/YouTube) con FX cibernéticos (scan lines, grid, sweep, matrix rain canvas, corner brackets), título dinámico bicolor, sección Historia (texto + imagen + stats), Alianzas grid, CTA eventos.
*   `eventos.blade.php` — Listado de eventos activos.
*   `djs.blade.php` — Listado de DJs aliados.
*   `galeria.blade.php` — Galería con álbumes, lightbox Alpine.js.
*   `alianzas.blade.php` — Cards horizontales alternadas con foto + descripción + CTA.
*   `nosotros.blade.php` — Header uniforme + sección con imagen integrada al contenido + visión/misión + CTA.
*   `contacto.blade.php` — Info de contacto + botones de redes sociales (IG, FB, TikTok) + CTA.

Layout base público: `layouts/public.blade.php` (navbar de 2 filas con logo centrado arriba y nav links abajo, grid CSS para centrado garantizado; footer con social hub, navegación y logo; íconos sociales IG/FB/TikTok dinámicos).

---

## 9. Plan de Fases

### Fase 1: Entorno — ✅ COMPLETO
*   Instalación Laravel 12 + Breeze.
*   Configuración MySQL + Migraciones (11 tablas).
*   Virtual Host `luminary.test` en XAMPP.

### Fase 2: Admin Backend — ✅ COMPLETO
*   Integración Tabler + jQuery + DataTables.
*   CRUD DJs, Eventos, Álbumes, Galería, Partners.
*   Módulo About Us (título, contenido, visión, misión, hero image).
*   Configuración Global Settings (logos separados público/admin, hero background, datos de contacto/footer con TikTok, imagen sección historia home).
*   Servicio `ImageOptimizer` aplicado a todos los controladores (WebP/GD nativo).

### Fase 3: Frontend Público — 🔄 EN PROCESO
*   **Completo:** Layout público, 7 páginas (Home, Eventos, DJs, Galería, Alianzas, Nosotros, Contacto), navbar de dos filas, footer con social hub, hero del home con efectos ciberpunk (scan lines, grid, sweep, matrix rain canvas, corner brackets pulsantes), título bicolor dinámico, página Alianzas con cards alternadas, página Nosotros refactorizada con imagen integrada al contenido, TikTok como tercera red social.
*   **Pendiente:** poblamiento con datos reales, refinamiento visual página por página, revisión responsive mobile, SEO básico, optimización de assets.
