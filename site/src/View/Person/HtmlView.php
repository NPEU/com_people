<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_people
 *
 * @copyright   Copyright (C) NPEU 2023.
 * @license     MIT License; see LICENSE.md
 */

namespace NPEU\Component\People\Site\View\Person;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
#use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Router\Route;
#use Joomla\CMS\Plugin\PluginHelper;
#use Joomla\Event\Event;

/**
 * Person Component HTML View
 */
class HtmlView extends BaseHtmlView {

    /**
     * The person object
     *
     * @var    \JObject
     */
    protected $item;

    /**
     * The page parameters
     *
     * @var    \Joomla\Registry\Registry|null
     */
    protected $params;

    /**
     * The item model state
     *
     * @var    \Joomla\Registry\Registry
     */
    protected $state;


    protected function getTitle() {
        return  $this->title = $menu->title;
    }


    public function display($template = null)
    {
        $app          = Factory::getApplication();
        $input        = $app->input;

        $person_id        = (int) $input->get('id');
        $model            = $this->getModel();
        $model->person_id = $person_id;

        $this->state  = $this->get('State');
        $this->params = $this->state->get('params');
        $this->people  = $this->get('People');
        $this->person  = $this->get('Person');


        #echo '<pre>'; var_dump($this->state); echo '</pre>'; exit;
        #echo '<pre>'; var_dump($this->person); echo '</pre>'; exit;


        $this->state  = $this->get('State');
        $this->params = $this->state->get('params');

        $document     = Factory::getDocument();


        $uri    = Uri::getInstance();
        $menus  = $app->getMenu();
        $menu   = $menus->getActive();


        $uri    = Uri::getInstance();
        $menus  = $app->getMenu();
        $menu   = $menus->getActive();
        #echo '<pre>'; var_dump($menu); echo '</pre>'; exit;
        $this->menu_params = $menu->getParams();

        $pathway = $app->getPathway();

        // Fix the pathway link:
        // I don't think this should be necessary - I thought the Router should handle this???

        $pathway = $app->getPathway();

        $pathway_items = $pathway->getPathway();
        $last_item =  array_pop($pathway_items);
        $last_item->name =  $this->person['name'];
        $pathway_items[] = (object) ['name' => $menu->title, 'link' => $menu->link];
        $pathway_items[] = $last_item;

        $pathway->setPathway($pathway_items);

        // Set the menu (page) title to be this item:
        $menu->title = trim($this->person['title'] . ' ' . $this->person['name']);


        $this->return_page = base64_encode($uri::base() . $menu->route);

        // Check for errors.
        $errors = $this->get('Errors', false);

        if (!empty($errors)) {
            Log::add(implode('<br />', $errors), Log::WARNING, 'jerror');

            return false;
        }
        // Call the parent display to display the layout file
        parent::display($template);

        /*

        $user = JFactory::getUser();
        $user_is_root = $user->authorise('core.admin');

        $item = $this->get('Item');
        // We may not actually want to show the form at this point (though we could if we wanted to
        // include the form AND the record on the same page - especially if it's displayed via a
        // modal), but it's useful to have the form so we can retrieve language strings without
        // having to manually reclare them, along with any other properties of the form that may be
        // useful:
        $form = $this->get('Form');
        #echo '<pre>'; var_dump($item); echo '</pre>'; exit;
        #echo '<pre>'; var_dump($form); echo '</pre>'; exit;
        #echo '<pre>'; var_dump($this->getLayout()); echo '</pre>'; exit;

        $app    = JFactory::getApplication();
        $menus  = $app->getMenu();
        $menu   = $menus->getActive();
        #echo '<pre>'; var_dump($menu); echo '</pre>'; exit;
        #echo '<pre>'; var_dump(JRoute::_($menu->link)); echo '</pre>'; exit;
        #echo '<pre>'; var_dump(URI::base()); echo '</pre>'; exit;
        #echo '<pre>'; var_dump($item->id); echo '</pre>'; exit;
        #echo '<pre>'; var_dump($user, $item); echo '</pre>'; exit;
        #echo '<pre>'; var_dump($user->id, $item->created_by); echo '</pre>'; exit;

        $this->return_page = base64_encode(URI::base() . $menu->route);


        $is_new = empty($item->id);
        $is_own = false;
        if (!$is_new && ($user->id == $item->created_by)) {
            $is_own = true;
        }


        if ($user_is_root) {
            $authorised = true;
        } elseif ($is_new) {
            $authorised = $user->authorise('core.create', 'com_people');
        } elseif ($is_own) {
            $authorised = $user->authorise('core.edit.own', 'com_people');
        }
        else {
            $authorised = $user->authorise('core.edit', 'com_people');
        }

        if ($authorised !== true && $this->getLayout() == 'form') {
            JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));

            return false;
        }


        // Add to breadcrumbs:
        if ((!$breadcrumb_title = $item->title) && $is_new) {
            $breadcrumb_title  = JText::_('COM_PEOPLE_PAGE_TITLE_ADD_NEW');
        }

        #echo '<pre>'; var_dump($breadcrumb_title); echo '</pre>'; exit;

        $app     = JFactory::getApplication();
        $pathway = $app->getPathway();
        $pathway->addItem($breadcrumb_title);

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }


        // Assign data to the view
        $this->item = $item;
        // Although we're not actually showing the form, it's useful to use it to be able to show
        // the field names without having to explicitly state them (more DRY):
        $this->form = $form;

        */




        /*
        $app = Factory::getApplication();

        $this->item   = $this->get('Item');
        $this->state  = $this->get('State');
        $this->params = $this->state->get('params');

        // Create a shortcut for $item.
        $item = $this->item;

        $item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;

        $temp         = $item->params;
        $item->params = clone $app->getParams();
        $item->params->merge($temp);

        $offset = $this->state->get('list.offset');

        $app->triggerEvent('onContentPrepare', array('com_weblinks.weblink', &$item, &$item->params, $offset));

        $item->event = new \stdClass;

        $results = $app->triggerEvent('onContentAfterTitle', array('com_weblinks.weblink', &$item, &$item->params, $offset));
        $item->event->afterDisplayTitle = trim(implode("\n", $results));

        $results = $app->triggerEvent('onContentBeforeDisplay', array('com_weblinks.weblink', &$item, &$item->params, $offset));
        $item->event->beforeDisplayContent = trim(implode("\n", $results));

        $results = $app->triggerEvent('onContentAfterDisplay', array('com_weblinks.weblink', &$item, &$item->params, $offset));
        $item->event->afterDisplayContent = trim(implode("\n", $results));

        parent::display($tpl);
        */


        /*// Assign data to the view
        $this->msg = 'Get from API';
        */

    }

}