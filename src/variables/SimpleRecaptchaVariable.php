<?php
/**
 * Simple Recaptcha plugin for Craft CMS 3.x
 *
 * Allows the addition of Google's reCAPTCHA v3 to any simple HTML form and verifies server-side.
 *
 * @link      https://www.headjam.com.au
 * @copyright Copyright (c) 2022 Ben Norman
 */

namespace headjam\simplerecaptcha\variables;

use headjam\simplerecaptcha\SimpleRecaptcha;

use Craft;

/**
 * Simple Recaptcha Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.simpleRecaptcha }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Ben Norman
 * @package   SimpleRecaptcha
 * @since     1.0.0
 */
class SimpleRecaptchaVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Render the Google reCAPTCHA V3 widget.
     * {{ craft.simpleRecaptcha.render('users/login') }}
     *
     * @param string $action The action to attempt after verification.
     * @param array $optional
     * @return string
     */
    public function render(string $action, array $options = [])
    {
        return SimpleRecaptcha::$plugin->recaptcha->render($action, $options);
    }

    /**
     * Render the reCAPTCHA site key as defined in settings.
     *
     * @return string
     */
    public function sitekey()
    {
        $settings = SimpleRecaptcha::$plugin->getSettings();
        return $settings->getSiteKey();
    }
}
