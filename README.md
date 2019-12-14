# thinkwp

Contributors: ThinkShout Inc., Automattic

Tags: custom-background, custom-logo, custom-menu, featured-images,
threaded-comments, translation-ready

- Requires at least: 4.5
- Tested up to: 4.8
- Stable tag: 1.0.0
- License: GNU General Public License v2 or later
- License URI: LICENSE

A starter theme called thinkwp.

## Description

A starter theme for Wordpress site builds that uses Webpack.

## Making a copy

To copy and rename this theme, run the following:

```bash
cd <your WP theme directory>
git clone git@github.com:thinkshout/thinkwp.git my_theme_name
cd my_theme_name
./update_theme_name.sh my_theme_name
```

## Installation

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme and Choose File, then select the theme's .zip file.
Click Install Now.
3. Click Activate to use your new theme right away.

## Development

### Setup

```bash
git clone git@github.com:thinkshout/thinkwp.git
cd thinkwp
npm install
```

### Use

```bash
# Start a production build and watch for changes.
npm run start
# Start a development build and watch for changes.
npm run start:dev
# Run a one-time production build.
npm run build
# Run a one-time development build.
npm run build:dev
```

## Code Sniffer

- Add to composer.json (replace thinkwp with the name of your theme):

```
"code-sniff": [
  "./vendor/bin/phpcs --standard=WordPress ./web/wp-content/plugins/custom",
  "./vendor/bin/phpcs --standard=./web/wp-content/themes/custom/thinkwp/phpcs.xml ./web/wp-content/themes/custom/thinkwp"
],
```

- Run: `composer run-script code-sniff`

## Credits

- Based on Underscores https://underscores.me/, (C) 2012-2017 Automattic, Inc.,
[GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
- normalize.css https://necolas.github.io/normalize.css/, (C) 2012-2016
Nicolas Gallagher and Jonathan Neal, [MIT](https://opensource.org/licenses/MIT)
