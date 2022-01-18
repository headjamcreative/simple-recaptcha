# Simple Recaptcha plugin for Craft CMS 3.x

Allows the addition of Google's reCAPTCHA V3 to any simple HTML form and verifies server-side.
Heavily influenced by [Matt West's Craft reCAPTCHA](https://github.com/matt-west/craft-recaptcha) for Google reCAPTCH V2.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require headjam/simple-recaptcha

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Simple Recaptcha.

## Configuring Simple Recaptcha

1. [Sign up for reCAPTCHA API key](https://www.google.com/recaptcha/admin).
2. Open the Craft admin and go to Settings → Plugins → Simple Recaptcha → Settings.
3. Add your `site key` and `secret key`, then save. Alternatively, copy the contents of `src/config.php` to `config/simple-recaptcha.php` and update.
4. Add the recaptcha template tag to your forms.

## Using Simple Recaptcha

To use Simple Recaptcha, add the recaptcha.render tag with the url you are protecting. For example:
```twig
{{ craft.recaptcha.render('users/login') }}
```

Brought to you by [Ben Norman](https://www.headjam.com.au)