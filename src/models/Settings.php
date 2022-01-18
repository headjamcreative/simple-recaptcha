<?php
/**
 * Simple Recaptcha plugin for Craft CMS 3.x
 *
 * Allows the addition of Google's reCAPTCHA v3 to any simple HTML form and verifies server-side.
 *
 * @link      https://www.headjam.com.au
 * @copyright Copyright (c) 2022 Ben Norman
 */

namespace headjam\simplerecaptcha\models;

use headjam\simplerecaptcha\SimpleRecaptcha;

use Craft;
use craft\base\Model;

/**
 * SimpleRecaptcha Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * @author    Ben Norman
 * @package   SimpleRecaptcha
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Site key model attribute
     *
     * @var string
     */
    public $siteKey = '';

    /**
     * Secret key model attribute
     *
     * @var string
     */
    public $secretKey = '';

    /**
     * Score model attribute
     *
     * @var float
     */
    public $scoreThreshold = 0.5;

    /**
     * Share addresses model attribute
     *
     * @var bool
     */
    public $shareAddresses = false;



    // Public Methods
    // =========================================================================

    /**
     * @return string the parsed site key
     */
    public function getSiteKey(): string
    {
        return Craft::parseEnv($this->siteKey);
    }

    /**
     * @return string the parsed secret key
     */
    public function getSecretKey(): string
    {
        return Craft::parseEnv($this->secretKey);
    }

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['scoreThreshold', 'number'],
            [['siteKey', 'secretKey'], 'string'],
            [['siteKey', 'secretKey', 'scoreThreshold'], 'required']
        ];
    }
}
