<?php
/**
 * Simple Recaptcha plugin for Craft CMS 3.x
 *
 * Allows the addition of Google's reCAPTCHA v3 to any simple HTML form and verifies server-side.
 *
 * @link      https://www.headjam.com.au
 * @copyright Copyright (c) 2022 Ben Norman
 */

namespace headjam\simplerecaptcha\services;

use headjam\simplerecaptcha\SimpleRecaptcha;

use Craft;
use craft\base\Component;
use craft\web\View;
use GuzzleHttp;

/**
 * Recaptcha Service
 *
 * @author    Ben Norman
 * @package   SimpleRecaptcha
 * @since     1.0.0
 */
class Recaptcha extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * Render the required reCAPTCHA HTML.
     *
     * @param string $action The action to run after verification.
     * @param array $config Optional config overrides for the reCAPTCHA HTML.
     *
     * @return mixed
     */
    public function render(string $action, array $config = [])
    {
        // Define settings for easy reference
        $settings = SimpleRecaptcha::$plugin->getSettings();
        $sitekey = $settings->getSitekey();
        // Localise
        $siteLanguage = Craft::$app->getSites()->getCurrentSite()->language;
        $language = $siteLanguage ? $siteLanguage : 'en';
        // Load required script
        Craft::$app->view->registerJsFile('https://www.google.com/recaptcha/api.js?render=' . $sitekey . '&hl=' . $language, ['async' => 'async', 'defer' => 'defer']);
        // Set smart defaults, but override them with any configs the user provides
        $defaults = array(
            'action' => $action,
            'sitekey' => $sitekey,
            'captchaAction' => 'submit'
        );
        $options = array_merge($defaults, $config);
        // Render the HTML
        $oldMode = Craft::$app->view->getTemplateMode();
        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        $html = Craft::$app->view->renderTemplate('simple-recaptcha/_recaptcha', $options);
        Craft::$app->view->setTemplateMode($oldMode);
        echo $html;
        return;
    }

    /**
     * Attempt to verify the reCAPTCHA submission with Google.
     * Return true if valid, else false.
     *
     * @param string $token The token from the hidden reCAPTCHA input
     *
     * @return bool
     */
    public function verify($token)
    {
        // Define the default settings
        $settings = SimpleRecaptcha::$plugin->getSettings();
        $params = array(
            'secret' =>  $settings->getSecretKey(),
            'response' => $token
        );
        // Set the remoteip if the shareAddresses setting has been enabled
        if ($settings->shareAddresses) {
            $ip = Craft::$app->getRequest()->userIP;
            if ($ip) {
                $params['remoteip'] = $ip;
            }
        }
        // Send the verification request
        $client = new GuzzleHttp\Client();
        $verificationUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $response = $client->request('POST', $verificationUrl, ['form_params' => $params]);

        // Return true if request successful and passes the minimum score threshold
        if ($response->getStatusCode() == 200) {
            $json = json_decode($response->getBody());
            return $json->success && isset($json->score) && $json->score >= $settings->scoreThreshold;
        } else {
            return false;
        }
    }
}