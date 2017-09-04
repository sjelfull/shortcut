<?php
/**
 * Shortcut plugin for Craft CMS
 *
 * Shortcut Record
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   Shortcut
 * @since     1.0.0
 */

namespace Craft;

class ShortcutRecord extends BaseRecord
{
    /**
     * @return string
     */
    public function getTableName ()
    {
        return 'shortcut';
    }

    /**
     * @access protected
     * @return array
     */
    protected function defineAttributes ()
    {
        return [
            'elementType' => [ AttributeType::String, 'default' => null ],
            'locale'      => [ AttributeType::Locale, 'default' => null ],
            'code'        => [ AttributeType::String, 'default' => '' ],
            'url'         => [ AttributeType::String, 'default' => '' ],
            'urlHash'     => [ AttributeType::String, 'default' => '' ],
            'hits'        => [ AttributeType::Number, 'default' => 0 ],
        ];
    }

    /**
     * @return array
     */
    public function defineRelations ()
    {
        return [
            'element' => [ static::BELONGS_TO, 'ElementRecord', 'required' => false, 'onDelete' => static::CASCADE ],
        ];
    }
}