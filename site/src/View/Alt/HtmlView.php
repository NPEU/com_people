<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_people
 *
 * @copyright   Copyright (C) NPEU 2023.
 * @license     MIT License; see LICENSE.md
 */

namespace NPEU\Component\People\Site\View\Alt;

defined('_JEXEC') or die;

#use Joomla\CMS\Helper\TagsHelper;
#use Joomla\CMS\Plugin\PluginHelper;
#use Joomla\Event\Event;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

use NPEU\Component\People\Site\View;

//require_once(dirname(__DIR__) . '/Person/HtmlView.php');

/**
 * Person Component HTML View
 */
class HtmlView extends \NPEU\Component\People\Site\View\People\HtmlView {

    protected $page_title = 'Alt View';


    protected function getTitle($title = '') {
        return $this->page_title;
    }

    public function display($template = null) {

        $app = Factory::getApplication();
        $menu = $app->getMenu()->getActive();
        $menu_title = $menu->title;

        $pathway = $app->getPathway();
        $pathway->addItem($this->page_title);

        $menu->title = $this->page_title;
        parent::display($template);
    }

}