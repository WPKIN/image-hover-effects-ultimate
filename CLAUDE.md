# Image Hover Effects Ultimate — Plugin Guide for Claude

## Overview

WordPress plugin for CSS3 image hover effects. Version **9.11.5**. Namespace: `OXI_IMAGE_HOVER_PLUGINS`.
Free + Pro (Freemius). 10 effect modules, 500+ animations, 1500+ layouts.

---

## Directory Structure

```
image-hover-effects-ultimate/
├── index.php                  # Main plugin file, bootstraps everything
├── Classes/
│   ├── ImageApi.php           # All AJAX handlers (save/delete/import/export)
│   ├── Controls.php           # Control type constants (TEXT, SELECT, SLIDER, etc.)
│   ├── Installation.php       # DB table creation on activation
│   ├── Support_Reviews.php    # Review notice
│   └── Support_Recommended.php
├── Helper/
│   ├── Admin_helper.php       # Trait: admin menu render, permission check
│   ├── CSS_JS_Loader.php      # Trait: enqueue scripts/styles, nonce setup
│   ├── Sanitization.php       # Trait: all admin form controls (add_control, etc.)
│   └── Public_Helper.php      # Trait: public-facing helpers
├── Includes/
│   ├── Assets.php             # Script/style enqueue hooks
│   ├── Frontend.php           # Frontend handler (minimal)
│   ├── Admin.php              # Bootstraps admin menu + notice
│   └── Admin/
│       ├── Menu.php           # WordPress admin menu registration
│       ├── Notice.php         # Admin notices
│       └── Pages/
│           ├── Admin.php      # Main effects listing page
│           ├── Shortcode.php  # Shortcode list page
│           ├── Settings.php   # Plugin settings page
│           └── GettingStarted.php
├── Page/
│   ├── Admin_Render.php       # Abstract base for all effect admin editors
│   ├── Public_Render.php      # Abstract base for all public shortcode renders
│   ├── Create.php             # Template creation page
│   ├── PreviewFrame.php       # Iframe preview renderer
│   └── Welcome.php
├── Modules/                   # One folder per effect type
│   ├── General/
│   ├── Caption/
│   ├── Flipbox/
│   ├── Button/
│   ├── Square/
│   ├── Lightbox/
│   ├── Comparison/
│   ├── Magnifier/
│   ├── Carousel/
│   ├── Filter/
│   ├── Display/
│   └── Compailer.php / Dynamic.php / Elementor.php / Widget.php
├── assets/
│   ├── backend/css/
│   │   ├── single_editor_page.css   # Editor UI styles (header, buttons, layout)
│   │   ├── admin.css
│   │   └── global-admin.css
│   └── backend/js/
│       ├── editors.js               # Main admin editor JS (all click handlers)
│       └── preview-controllers.js
└── vendor/                    # Composer: Freemius SDK
```

---

## Module Structure

Each module (e.g., `Modules/General/`) follows this pattern:

```
General/
├── General.php         # Module entry, registers shortcode
├── Modules.php         # Module metadata
├── Layouts/            # JSON layout templates
├── Files/              # Module-specific CSS/JS assets
├── Admin/
│   └── Effects1.php    # Admin editor — extends Admin_Render
│   └── Effects2.php    # (one file per style number)
└── Render/
    └── Effects1.php    # Public render — extends Public_Render
    └── Effects2.php
```

**Style name format:** `general-1`, `flipbox-3`, `caption-7` etc. (module-number)

**Dynamic class resolution** — used throughout `ImageApi.php`:
```php
$s = explode('-', $style_name);  // e.g. ['general', '1']
$CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
```
This is core architecture — do not refactor without updating all callers.

---

## Database Tables

| Table | Purpose |
|-------|---------|
| `{prefix}image_hover_ultimate_style` | Parent rows — one per shortcode (name, style_name, rawdata JSON, stylesheet CSS, font_family) |
| `{prefix}image_hover_ultimate_list` | Child rows — one per image item within a shortcode (styleid FK, rawdata JSON) |
| `{prefix}oxi_div_import` | Active shortcode tracking, font imports |

`rawdata` columns store JSON blobs of all admin settings.
`stylesheet` stores generated CSS (rebuilt on every save via `template_css_render()`).

---

## AJAX Endpoints

All registered in `Classes/ImageApi.php` → `build_api()`:

| Hook | Handler | Auth |
|------|---------|------|
| `wp_ajax_image_hover_settings` | `save_action()` | `get_permissions_check()` + nonce |
| `wp_ajax_image_hover_ultimate` | `ajax_action()` | `get_permissions_check()` + nonce |
| `wp_ajax_nopriv_image_hover_ultimate` | `ajax_action()` | `get_permissions_check()` + nonce |
| `wp_ajax_oxi_image_hover_preview_frame` | `preview_frame_action()` | — |

**Nonce:** `image_hover_ultimate` — generated only in admin pages via `CSS_JS_Loader::admin_js()`.

### `save_action()` — main admin AJAX
Routes to `post_{functionname}()` methods on `ImageApi`. Key methods:
- `post_elements_template_style()` — saves design settings
- `post_elements_template_modal_data()` — saves/updates an image item
- `post_elements_template_modal_data_delete()` — deletes an item
- `post_create_new()` — creates a new shortcode from template file
- `post_layouts_clone()` — clones a shortcode
- `post_shortcode_delete()` — deletes a shortcode
- `post_shortcode_export()` — exports JSON
- `post_web_import()` — imports from plugin's built-in template library
- `post_template_name()` — renames a shortcode
- `post_notice_dissmiss()` — dismisses admin notices

### `ajax_action()` — secondary AJAX
Instantiates a class from `OXI_IMAGE_HOVER_PLUGINS` namespace and calls `__rest_api_post()` on it. Used by some module-specific operations.

---

## CSS Generation Flow

1. Admin saves settings → `post_elements_template_style()` → calls `template_css_render($settings)`
2. `template_css_render()` (in `Page/Admin_Render.php`) runs `register_controls()` which populates `$this->CSSDATA`
3. `$this->CSSDATA` is compiled into a CSS string and saved to `stylesheet` column in DB
4. On frontend, `Public_Render` reads `stylesheet` from DB and adds to `Public_Render::$pending_late_css`
5. `Assets::print_late_styles()` outputs `<style>` tag in footer

**Important:** `</style>` is stripped from `$css_output` before output (security fix, v9.11.5).

---

## Permission System

Plugin has a custom permission setting (`oxi_image_user_permission` option) that stores a WordPress role.
`ImageApi::get_permissions_check()` resolves this role to its first capability and calls `current_user_can()`.
Default falls back to `manage_options` (admin-only).

Always use `$this->get_permissions_check()` for capability checks — do not hardcode `manage_options`.

---

## Security Rules (enforced since v9.11.5)

- **Path traversal protection:** `post_create_new()` and `post_web_import()` use `realpath()` to confirm files are inside the plugin directory before reading.
- **CSS injection:** `post_elements_template_style()` strips `</style>` from rawdata before DB storage.
- **Output sanitization:** `print_late_styles()` strips `</style>` before echoing CSS.
- **Authorization:** `ajax_action()` calls `get_permissions_check()` before any processing.
- **Nonce:** All write operations verify `image_hover_ultimate` nonce.

---

## Admin Editor UI

Header is rendered by `Page/Admin_Render.php` → `oxi_admin_edit_page_header()`.

Header left: Back | Dashboard | Shortcode List | **How to use?** (docs link)
Header right: Upgrade (pro) | Visit Site | [Name input] + **Rename** button | Save

- **Rename** button JS handler: `editors.js` → `#addonsstylenamechange` click → calls `post_template_name`
- **Save** button (sidebar): `editors.js` → `#oxi-addons-templates-submit` click → calls `post_elements_template_style`
- Main editor CSS: `assets/backend/css/single_editor_page.css`
- Main editor JS: `assets/backend/js/editors.js`

### Key CSS classes (single_editor_page.css)
| Class | Purpose |
|-------|---------|
| `.oxi-addons-header` | Fixed top header bar |
| `.oxi-addons-header-left a` | Left nav links (Back, Dashboard, etc.) |
| `.oxi-btn-howto` | "How to use?" doc link — blue `#1A73E8` |
| `.oxi-header-name-save-btn` | Rename button — blue `#1A73E8` |
| `.oxi-btn-visit` | Visit Site button |
| `.oxi-btn-upgrade` | Upgrade button — orange theme |

---

## Key Constants

Defined in `index.php` → `define_constance()`:

| Constant | Value |
|----------|-------|
| `OXI_IMAGE_HOVER_PATH` | Absolute path to plugin folder (trailing slash) |
| `OXI_IMAGE_HOVER_URL` | URL to plugin folder (trailing slash) |
| `OXI_IMAGE_HOVER_PLUGIN_VERSION` | Current version string |

---

## Changelog Location

`readme.txt` → `== Changelog ==` section. Format:
```
= X.X.X =
* 🔒 Security: ...
* 🐛 Fix: ...
* ✨ Improvement: ...
* 🆕 New: ...
```
Use `:` after bold feature names. Use `,` for sentence continuations. No `—` em dashes.
