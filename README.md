# Kntnt's auto excerpt generator

WordPress plugin that creates a better auto excerpt than builtin.

## Description

An automatic excerpt is generated if non is given.

If *[Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/)* (*ACF*) is installed and a field with the slug `lead` exists, then the content of that field is used as excerpt.

If ACF is not installed or there is no field with a slug `lead`, then the first complete paragraph of the body text is used.

The plugin also provdies the excerpt as the meta value for the meta key `_genesis_description`. Some SEO plugins, e.g. [The SEO Framework](https://sv.wordpress.org/plugins/autodescription/) and [Yoast SEO](https://sv.wordpress.org/plugins/wordpress-seo/), uses this value as fallback if no meta description is given.

## Installation

Install the plugin the [usually way](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

## Changelog

### 1.0.2

Moved auto generation of _genesis_description to new plugin.

### 1.0.1

Excerpts are now auto generated also outside the loop.

### 1.0.0

Initial release.
