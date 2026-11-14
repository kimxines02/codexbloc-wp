# Codexbloc theme

Very light WordPress + WooCommerce theme for selling plugins, themes and (soon) PrestaShop modules.
Tailwind CSS is compiled to one ~10 KB (gzipped) stylesheet. No web fonts, no jQuery of its own, no page builder.

## Install
1. Appearance > Themes > Add New > Upload Theme > choose `codexbloc.zip` > Activate.
2. Install and activate WooCommerce. On activation the theme creates three product categories
   (WordPress Plugins, WordPress Themes, PrestaShop Modules) and the header menu links to them automatically.
3. Settings > Reading: leave "Your homepage displays" on "Your latest posts" (the front-page template is used either way). Pick a Posts page if you want a Blog link.
4. Appearance > Customize > Codexbloc: accent colour, hero text, buttons, contact email, social links.
   Logo: Site Identity > Logo, or drop `logo.png` into `assets/img/`.

## Adding products
Products > Add New. Fill the **Codexbloc details** box under the description:
- **Free products:** set the price to **0** (simple products). They show "Free" and a **Free download** button.
  Customers must be logged in: visitors are sent to My Account to log in or register (email only), then straight to the download.
  Attach the file under *Downloadable* in the product data; the first download records a ₱0 order so the file
  is served through WooCommerce's protected link and listed in My Account > Downloads.
  No file but a **WordPress.org URL**? Logged-in customers are sent to WordPress.org instead.
- Version, requirements, key features (one per line), demo and docs links.
Featured products (star in the product list) appear first on the homepage.

## Editing styles
Source is in `src/input.css` and `tailwind.config.js`.
```
npm install
npm run build   # writes assets/css/main.css
npm run dev     # watch mode
```
Homepage copy: `inc/defaults.php` (pillars, services, About page copy).
Website services show no prices; their buttons link to the contact form with the
"Custom project / services" topic pre-selected (`/contact/?topic=project`).

## Deployment
Pushing to `main` builds the production CSS and deploys the theme over explicit FTPS to the configured WordPress theme directory. Configure these repository Actions secrets before the first deployment:

- `FTP_SERVER`: FTPS hostname
- `FTP_USERNAME`: FTP account username
- `FTP_PASSWORD`: FTP account password
- `FTP_SERVER_DIR`: remote theme directory, including its trailing slash (for example, `/www/example.com/wp-content/themes/codexbloc/`)

The workflow deploys the theme files while excluding development dependencies and source files.
