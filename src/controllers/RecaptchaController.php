<?php
/**
 * Simple Recaptcha plugin for Craft CMS 3.x
 *
 * Allows the addition of Google's reCAPTCHA v3 to any simple HTML form and verifies server-side.
 *
 * @link      https://www.headjam.com.au
 * @copyright Copyright (c) 2022 Ben Norman
 */

namespace headjam\simplerecaptcha\controllers;

use headjam\simplerecaptcha\SimpleRecaptcha;

use Craft;
use craft\web\Controller;

/**
 * Recaptcha Controller
 *
 * @author    Ben Norman
 * @package   SimpleRecaptcha
 * @since     1.0.0
 */
class RecaptchaController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['verify-submission'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's actionVerifySubmission URL,
     * e.g.: actions/simple-recaptcha/recaptcha/verify-submission
     *
     * @return mixed
     */
    public function actionVerifySubmission()
    {
        // Request must be a POST
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();
        // Action to run if submission is verified
        $action = $request->getRequiredParam('verified-action');
        $isInternal = empty(parse_url($action)['scheme']);
        if ($isInternal) {
          $action = '/' . $action;
        }
        // Verify the recaptcha response
        $captcha = $request->getRequiredParam('g-recaptcha-response');
        $verified = SimpleRecaptcha::$plugin->recaptcha->verify($captcha);
        // If verified, pass to verified-action, else set session error and return null
        if ($verified) {
            return Controller::run($action, func_get_args());
        } else {
            Craft::$app->getSession()->setError(Craft::t('site', 'Unable to verify your submission.'));
            return null;
        }
    }
}
