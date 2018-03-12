# Kntnt's auto excerpt generator

WordPress mu-plugin that creates a better auto excerpt than builtin.

## Description

An automatic excerpt is generated if a manual is missing. This plugin generates a better auto excerpt than the builtin.

If *[Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/)* (*ACF*) is installed and a field with the slug `lead` exists, then the content of that field is used.

If ACF is not installed or there is no field with a slug `lead`, then the first complete paragraph of the body text is used.

## Installation

Install the plugin the [usually way](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

## Changelog

### 1.0.0

Initial release.
