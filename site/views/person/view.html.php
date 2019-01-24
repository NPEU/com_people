<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_people
 *
 * @copyright   Copyright (C) NPEU 2019.
 * @license     MIT License; see LICENSE.md
 */

defined('_JEXEC') or die;

// Import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the People Component
 */
class PeopleViewPerson extends JViewLegacy
{
    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise an Error object.
     */
    function display($tpl = null)
    {
        $person_id        = (int) JFactory::getApplication()->input->get('id');
        $model            = $this->getModel();
        $model->person_id = $person_id;
        $person           = $this->get('Person');

        $app   = JFactory::getApplication();
        $menus = $app->getMenu();
        $menu  = $menus->getActive();

        // Get the parameters
        $this->com_params  = JComponentHelper::getParams('com_people');
        $this->menu_params = $menu->params;


        // Add to breadcrumbs:
        $app     = JFactory::getApplication();
        $pathway = $app->getPathway();
        $pathway->addItem($person['name']);

        // Change doc title:
        $doc = JFactory::getDocument();
        $doc->title .= ': ' . $person['name'];

        // Assign data to the view
        $this->person = $person;
        $this->title  = $menu->title;

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }
        // Display the view
        parent::display($tpl);
    }
}