<?php
/**
 * Simple Recaptcha plugin for Craft CMS 3.x
 *
 * Allows the addition of Google's reCAPTCHA v3 to any simple HTML form and verifies server-side.
 *
 * @link      https://www.headjam.com.au
 * @copyright Copyright (c) 2022 Ben Norman
 */

/**
 * Simple Recaptcha config.php
 *
 * This file exists only as a template for the Simple Recaptcha settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'simple-recaptcha.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    "siteKey" => "",
    "secretKey" => "",
    "scoreThreshold" => 0.5,
    "shareAddresses" => false
];
