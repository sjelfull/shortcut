<?php
/**
 * Shortcut plugin for Craft CMS
 *
 * Shortcut Variable
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   Shortcut
 * @since     1.0.0
 */

namespace Craft;

class ShortcutVariable
{
    /**
     */
    public function get ($options = [ ])
    {
        return craft()->shortcut->get($options);
    }
}