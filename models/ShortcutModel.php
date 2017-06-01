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
            'id'        => [ AttributeType::Number, 'default' => null ],
            'code'      => [ AttributeType::String, 'default' => '' ],
            'url'       => [ AttributeType::String, 'default' => '' ],
            'urlHash'   => [ AttributeType::String, 'default' => '' ],
            'hits'      => [ AttributeType::Number, 'default' => 0 ],
            'elementId' => [ AttributeType::Number, 'default' => null ],
        ]);
    }

    public function getUrl ()
    {
        return UrlHelper::getSiteUrl('s/' . $this->getAttribute('code'));
    }

    public function getRealUrl ()
    {
        return $this->getAttribute('url');
    }

    public function redirect ()
    {
        return craft()->request->redirect($this->getAttribute('url'));
    }
}