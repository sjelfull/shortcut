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

        craft()->on('elements.onSaveElement', function (Event $event) {
            if ( !$event->params['isNewElement'] ) {
                craft()->shortcut->onSaveElement($event->params['element']);
            }
        });
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
        return '1.0.1';
    }

    /**
     * @return string
     */
    public function getSchemaVersion ()
    {
        return '1.0.2';
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
        $urlSegment = craft()->config->get('urlSegment', 'shortcut') ?: 's';


        return [
            // (?P<indexId>\w+)
            $urlSegment . '/(?P<code>\w+)' => [ 'action' => 'shortcut/get' ]
        ];
    }
}