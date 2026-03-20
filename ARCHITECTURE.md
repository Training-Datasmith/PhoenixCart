# PhoenixCart Architecture

## Purpose

CE Phoenix (PhoenixCart) is a modern PHP e-commerce platform forked from osCommerce. It provides a full-featured online storefront and admin panel, designed for PHP 7.4+ with `strict_types` throughout.

## Directory Structure

```
PhoenixCart/
├── admin/                      # Admin panel pages and actions
│   ├── includes/
│   │   ├── actions/            # Action handlers (CRUD per module)
│   │   └── classes/            # Admin-specific classes
├── includes/
│   ├── classes/                # Core business logic classes
│   │   ├── magic/              # Surface/pipeline pattern for request handling
│   ├── modules/                # Pluggable content/feature modules
│   │   ├── content/            # Page-section content modules
│   │   ├── pi/                 # Product-info section modules
│   │   └── customer_data/      # Customer data form modules
│   └── version.php             # Application version string
├── templates/                  # Storefront templates (default theme)
├── install/                    # Installation wizard
└── account.php                 # Front-controller entry points (one per page)
```

## Key Design Decisions

- **Class autoloading**: A custom `class_index` loader maps class names to file paths. No Composer PSR-4 in legacy code paths.
- **Magic surfaces**: The `magic/` subdirectory implements a pipeline/surface pattern (`Application_Surface`, `Checkout_Surface`) that hooks into the request lifecycle.
- **Module system**: Content modules in `includes/modules/content/` declare `CONFIG_KEY_BASE` constants and implement `execute()`. They are installed/uninstalled via the admin panel into a `configuration` DB table.
- **Global state**: `$GLOBALS['db']`, `$GLOBALS['Template']`, etc. are the primary dependency access mechanism, set during bootstrap.
- **Session-backed cart**: `$_SESSION['cart']` holds a `Shopping_Cart` instance, guarded by `Application::ensure_session_cart()`.
- **String constants**: Configuration values (e.g. `'True'`/`'False'`, status codes) are stored as string constants loaded from the DB. These are candidates for enum conversion in PHP 8.1+.

## Extension Points

- Add a content module: create `includes/modules/content/{name}/cm_{name}.php` extending `abstract_executable_module`.
- Add an admin action: create `admin/includes/actions/{module}/{action}.php`.
- Override a template: copy files under `templates/default/` and adjust the template selection in admin.

## Dependency Flow

```
Entry point (*.php)
  → Application (bootstrap, session setup)
  → Magic surfaces (pipeline execution)
  → Content modules (execute → template output)
  → Database via $GLOBALS['db']
```
