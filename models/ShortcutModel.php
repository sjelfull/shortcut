<?php
/**
 * Shortcut plugin for Craft CMS
 *
 * Shortcut Model
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   Shortcut
 * @since     1.0.0
 */

namespace Craft;

class ShortcutModel extends BaseModel
{
    /**
     * @return array
     */
    protected function defineAttributes ()
    {
        return array_merge(parent::defineAttributes(), [
            'id'          => [ AttributeType::Number, 'default' => null ],
            'code'        => [ AttributeType::String, 'default' => '' ],
            'url'         => [ AttributeType::String, 'default' => '' ],
            'urlHash'     => [ AttributeType::String, 'default' => '' ],
            'hits'        => [ AttributeType::Number, 'default' => 0 ],
            'elementId'   => [ AttributeType::Number, 'default' => null ],
            'elementType' => [ AttributeType::String, 'default' => null ],
            'locale'      => [ AttributeType::Locale, 'default' => null ],
        ]);
    }

    public function getUrl ()
    {
        $urlSegment = craft()->config->get('urlSegment', 'shortcut') ?: 's';

        return UrlHelper::getSiteUrl($urlSegment . '/' . $this->getAttribute('code'));
    }

    public function getRealUrl ()
    {
        if ( !$this->elementId ) {
            return $this->getAttribute('url');
        }
        else {
            $element = craft()->elements->getElementById($this->elementId, $this->elementType, $this->locale);

            if ( !$element ) {
                throw new Exception(Craft::t('Could not find the url for element {id}', [ 'id' => $this->elementId ]));
            }

            return $element->getUrl();
        }
    }

    public function redirect ()
    {
        return craft()->request->redirect($this->getAttribute('url'));
    }
}