<?php
/**
 * Shortcut plugin for Craft CMS
 *
 * Shortcut Controller
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   Shortcut
 * @since     1.0.0
 */

namespace Craft;

class ShortcutController extends BaseController
{

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     * @access protected
     */
    protected $allowAnonymous = array(
        'actionGet',
    );

    /**
     */
    public function actionGet (array $variables = [ ])
    {
        if ( isset($variables['code']) ) {
            $shortcut = craft()->shortcut->getByCode($variables['code']);

            if ( $shortcut ) {
                craft()->shortcut->increaseHits($shortcut);
                $this->redirect($shortcut->getRealUrl());
            }
        }

        $this->redirect('/');
    }
}