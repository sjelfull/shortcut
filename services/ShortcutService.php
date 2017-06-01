<?php
/**
 * Shortcut plugin for Craft CMS
 *
 * Shortcut Service
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   Shortcut
 * @since     1.0.0
 */

namespace Craft;

class ShortcutService extends BaseApplicationComponent
{
    /**
     */
    public function get ($options = [ ])
    {
        if ( isset($options['element']) ) {
            $element = $options['element'];

            // Check if we have one
            $shortcut = $this->getByElementId($element->id);

            // If not, create one
            if ( !$shortcut ) {
                $shortcut = $this->create($options);
            }

            return $shortcut;
        }

        if ( isset($options['url']) ) {
            $url = $options['url'];

            // Check if we have one
            $shortcut = $this->getByUrl($url);

            // If not, create one
            if ( !$shortcut ) {
                $shortcut = $this->create($options);
            }

            return $shortcut;
        }

        return null;
    }

    public function create ($options = [ ])
    {
        $model = new ShortcutModel();

        if ( isset($options['element']) ) {
            $element = $options['element'];
            $url     = $element->getUrl();

            $model->elementId = $element->id;
            $model->url       = $url;
            $model->urlHash   = $this->hashForUrl($url);
        }

        if ( isset($options['url']) ) {
            $url            = $options['url'];
            $model->url     = $url;
            $model->urlHash = $this->hashForUrl($url);
        }

        $this->saveShortcut($model);

        return $model;
    }

    public function getById ($id = null)
    {
        $record = ShortcutRecord::model()->findById($id);

        if ( $record ) {
            return ShortcutModel::populateModel($record->getAttributes());
        }

        return null;
    }

    public function getByCode ($code = null)
    {
        $record = ShortcutRecord::model()->findByAttributes([ 'code' => $code ]);

        if ( $record ) {
            return ShortcutModel::populateModel($record->getAttributes());
        }

        return null;
    }

    public function getByUrl ($url = null)
    {
        $hash = $this->hashForUrl($url);

        $record = ShortcutRecord::model()->findByAttributes([ 'urlHash' => $hash ]);

        if ( $record ) {
            return ShortcutModel::populateModel($record->getAttributes());
        }

        return null;
    }

    public function getByElementId ($id = null)
    {
        $record = ShortcutRecord::model()->findByAttributes([ 'elementId' => $id ]);

        if ( $record ) {
            return ShortcutModel::populateModel($record->getAttributes());
        }

        return null;
    }

    public function increaseHits (ShortcutModel $shortcut)
    {
        $shortcut->hits = $shortcut->hits + 1;

        $this->saveShortcut($shortcut);
    }

    public function saveShortcut (ShortcutModel &$shortcut)
    {

        $isNew = !$shortcut->id;

        if ( $shortcut->validate() ) {
            if ( !$isNew ) {
                $record = ShortcutRecord::model()->findById($shortcut->id);

                if ( !$record ) {
                    throw new Exception('No shortcut record with ID ' . $shortcut->id . ' was found.');
                }
            }
            else {
                $record = new ShortcutRecord();
            }

            $record->url       = $shortcut->url;
            $record->urlHash   = $shortcut->urlHash;
            $record->code      = $shortcut->code;
            $record->hits      = $shortcut->hits;
            $record->elementId = $shortcut->elementId;


            if ( $record->save() && empty($record->code) ) {
                require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

                $hashids = new \Hashids\Hashids('This is a cool shortcut plugin', 5);

                $code         = $hashids->encode($record->id);
                $record->code = $code;

                if ( $record->save() ) {
                    $shortcut->code = $code;
                }

            }

        }

    }

    public function hashForUrl ($url = null)
    {
        return md5($url);
    }

}