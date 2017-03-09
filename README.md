# Taxonomy module for AsgardCMS 2

Module allow you to create vocabularies and terms. You can use it for creation categories, tags, and so on.
Module uses my own vendor package "alex/image" for uploading images.

## Installation

1. Put a module in "Modules" folder
2. Run commands:
`php artisan module:update taxonomy`
`php artisan module:migrate taxonomy`
3. Give permissions to the taxonomy module.

## Usage

Module doesn't have any settings or configuration. You can use it in a backend out of the box.

There are few helper functions for a frontend:

`Term::getList($vocabulary_name)` - return an key-value array indicating the term's depth with a seperator. It can be useful in select lists.
`$vocabulary_name` - vocabulary's machine name

`Term::renderTaxonomyMenu($vocabulary_name, $route, $entity_term = null)` - return html list of taxonomy tree
`$route` - route name for a term page
`$entity_term` - is optional. You can pass a term instance to add "active class" for a taxonomy menu when you view a node.

Example:

```
$gallery_category = Term::where('id', $gallery->category_id)->first();  
$categories = Term::renderTaxonomyMenu('gallery_categories', 'gallery.category.show', $gallery_category);
```