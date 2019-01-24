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
class PeopleViewPeople extends JViewLegacy
{
    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise an Error object.
     */
    public function display($tpl = null)
    {
        $people = $this->get('People');
        $app    = JFactory::getApplication();
        $menus  = $app->getMenu();
        $menu   = $menus->getActive();

        // Assign data to the view
        $this->people = $people;
        $this->title  = $menu->title;

        // Get the parameters
        $this->com_params  = JComponentHelper::getParams('com_people');
        $this->menu_params = $menu->params;

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }
        // Display the view
        parent::display($tpl);
    }
}