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

        if ( craft()->config->get('hideUrlSegment', 'shortcut') ) {
            craft()->onException = function (\CExceptionEvent $event) {
                if ( (($event->exception instanceof \CHttpException) && ($event->exception->statusCode == 404)) ||
                    (($event->exception->getPrevious() instanceof \CHttpException) && ($event->exception->getPrevious()->statusCode == 404))
                ) {
                    ShortcutPlugin::log('A 404 exception occurred', LogLevel::Info, false);

                    if ( craft()->request->isSiteRequest() && !craft()->request->isLivePreview() ) {
                        // See if we should redirect
                        $code     = craft()->request->getSegment(1);
                        $shortcut = craft()->shortcut->getByCode($code);

                        if ( $shortcut ) {
                            ShortcutPlugin::log(Craft::t('Found matching shortcut {code}, redirecting to {url}', [ 'code' => $code, 'url' => $shortcut->getRealUrl() ]), LogLevel::Info, false);

                            craft()->shortcut->increaseHits($shortcut);
                            craft()->request->redirect($shortcut->getRealUrl());
                        }
                    }
                }
            };
        }
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
        return '1.0.2';
    }

    /**
     * @return string
     */
    public function getSchemaVersion ()
    {
        return '1.0.3';
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