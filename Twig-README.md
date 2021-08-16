# How To Twig In WordPress

:wave: Hello! This theme is built to use the [Twig Templating Language](https://twig.symfony.com/) connected to WordPress via [Timber](https://timber.github.io/docs/) v1.

## Getting started From Scratch

To start from scratch you'll need to install [Timber](https://timber.github.io/docs/) and [Timber Acf WP Blocks composer package](https://github.com/palmiak/timber-acf-wp-blocks) via composer. Run `composer require timber/timber` & `composer require palmiak/timber-acf-wp-blocks` from either the project root or in anywhere else but be sure to accept the use of the existing composer file when prompted.

## Usage

### timber.php

The gap between Twig templating and WordPress is bridged by [Timber](https://timber.github.io/docs/guides/wp-integration/). Specifically, the `ThemeTimber` class in `lib/timber.php`. This file does a number of things including [directory setup](https://timber.github.io/docs/guides/template-locations/), base context setup, [gutenberg block setup](https://timber.github.io/docs/guides/gutenberg/), and acts as a [functions library](https://timber.github.io/docs/guides/functions/) for Twig templates.

### Content

[WordPress template files](https://developer.wordpress.org/themes/basics/template-files/) are used to call forward Twig template files and render content. For example, `page.php` in this case sets up wordpress page post types with a template context with content:

```php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
```

Where we're getting the base context for the site with `Timber::get_context()` containing site data, theme data, menus, as well as anything else added in the `ThemeTimber` class (see examples of data below).

Then it tells timber where to find the correct twig file(s) to render the page in preferential order:

```php
$templates = array('page/page-' . $post->slug . '.twig', $post->slug  . '.twig', 'templates/page.twig');
```

Finally, it renders the template with the build context:

```php
Timber::render($templates, $context, false);
```

At this point looks in the Twig directory (by default the `views` directory) for the matching twig file to use in rendering.

This approach can/should be repeated in all theme relevant template files (index.php, single.php, front-page.php, archive.php) not already present in the theme.

#### Page Templates

Page templates are stored first in the `templates` directory as definied in the `timber.php` file:

```php
Timber::$locations = [ get_template_directory() . '/templates', get_template_directory() ];
```

Adding a [new page template](https://timber.github.io/docs/guides/custom-page-templates/) requires a php file to make WordPress aware of it and to handle context setup and rendering as described above.

#### Post Types

After adding custom post types to the theme you'll want to create a single-{post-type-name}.php to handle rendering that post type if necessary. This operates in the same way as page templates with the caveat that their php files are stored at the root of the theme if they're needed.

#### Gutenberg Blocks

Adding custom Gutenberg blocks happens via the [Timber Acf WP Blocks composer package](https://github.com/palmiak/timber-acf-wp-blocks). To add a Gutenberg block simply add a twig template file in the `views/blocks` directory with something like the following structure:

```twig
{#
Title: Did You Know
Description: Custom block for did you know tiles
Category: formatting
Icon: align-wide
Keywords: block quote "did you know"
#}
<div class="{{classes}}" data-{{ block.id }}>
    <div class="did-you-know-tiles">
        <div class="grid">
            {% for tile in fields.did_you_know_tiles %}
            {% set gridClass = loop.index is odd ? 'grid__1to6' : 'grid__7to12' %}
            <div class="{{gridClass}} did-you-know-tiles__tile">
                <h2>{{tile.did_you_know_title}}</h2>
                <p>{{tile.did_you_know_text}}</p>
                {% if tile.did_you_know_source_link %}
                Source: <a href="{{tile.did_you_know_source_link.url}}">{{tile.did_you_know_source_link.title}}</a>
                {% endif %}
            </div>
            {% endfor %}
        </div>
    </div>
</div>

<style type="text/css">
[data-{{ block.id }}] {
    background-color: #e6e8f4;
    padding: 80px 0px;
}
</style>
```

The above example has fields built out. This is accomplished by adding a field group to ACF to display on the block in the editor. Those fields are added to the block `fields` context object.

### Twig Templating

By now you've noticed that we're breaking out of the traditional WordPress loop structure for our markup. Make use of the context object for post data, content, [ACF content](https://timber.github.io/docs/guides/acf-cookbook/), etc to provide all needed info/logic for the template.

## Context Data Examples

### Site data example

```js
{
  blogname: null,
  charset: "UTF-8",
  description: "",
  home_url: "https://web.studentdebtsmarter.localhost",
  id: null,
  language: "en-US",
  multisite: false,
  name: "Student Debt Smarter"
  ...etc
}
```

### Theme data example

```js
{
  ID: null,
  id: null,
  name: "studentdebtsmarter",
  object_type: null,
  parent: false,
  parent_slug: null,
  slug: "custom/studentdebtsmarter",
  uri: "https://web.studentdebtsmarter.localhost/wp-content/themes/custom/studentdebtsmarter",
  version: "1.0.0",
  ...etc
}
```

### Menu data example

```js
{
  _children: null,
  count: 2,
  depth: 0,
  filter: "raw",​​
  id: 2,
  items: Array [ {…}, {…} ],
  name: "Main Nav",
  object_type: "term",
  options: Object { depth: 0 },
  parent: 0,
  raw_options: Array [],
  slug: "main-nav",
  ...etc
}
```
