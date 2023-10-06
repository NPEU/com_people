<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_people
 *
 * @copyright   Copyright (C) NPEU 2023.
 * @license     MIT License; see LICENSE.md
 */

namespace NPEU\Component\People\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;


/**
 * People Component Controller
 */
class DisplayController extends BaseController {

    public function display($cachable = false, $urlparams = []) {
        $viewName = $this->input->get('view', '');
        $cachable = true;
        if ($viewName == 'form' || Factory::getApplication()->getIdentity()->get('id')) {
            $cachable = false;
        }

        $safeurlparams = [
            'id'   => 'INT', /* should be ARRAY if using `id:alias` style ids */
            'view' => 'CMD',
            'lang' => 'CMD',
        ];

        parent::display($cachable, $safeurlparams);

        return $this;
    }

}