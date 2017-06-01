<?php
/**
 * Shortcut plugin for Craft CMS
 *
 * Simple URL shortening
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   Shortcut
 * @since     1.0.0
 */

namespace Craft;

class ShortcutPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init ()
    {
        parent::init();
    }

    /**
     * @return mixed
     */
    public function getName ()
    {
        return Craft::t('Shortcut');
    }

    /**
     * @return mixed
     */
    public function getDescription ()
    {
        return Craft::t('Simple URL shortening');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl ()
    {
        return 'https://superbig.co/plugins/shortcut';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl ()
    {
        return 'https://superbig.co/plugins/shortcut/feed';
    }

    /**
     * @return string
     */
    public function getVersion ()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getSchemaVersion ()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper ()
    {
        return 'Superbig';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl ()
    {
        return 'https://superbig.co';
    }

    /**
     * @return bool
     */
    public function hasCpSection ()
    {
        return false;
    }

    public function registerSiteRoutes ()
    {
        return [
            // (?P<indexId>\w+)
            's/(?P<code>\w+)' => [ 'action' => 'shortcut/get' ]
        ];
    }
}