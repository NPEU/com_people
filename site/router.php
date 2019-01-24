<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_people
 *
 * @copyright   Copyright (C) NPEU 2019.
 * @license     MIT License; see LICENSE.md
 */

defined('_JEXEC') or die;

/**
 * Build the route for the com_content component
 *
 * @param   array   An array of URL arguments
 * @return  array   The URL arguments to use to assemble the subsequent URL.
 */
function PeopleBuildRoute(&$query)
{
    $segments = array();
    return $segments;
}

/**
 * Parse the segments of a URL.
 *
 * @param   array   The segments of the URL to parse.
 *
 * @return  array   The URL attributes to be used by the application.
 */
function PeopleParseRoute($segments)
{
    if (empty($segments)) {
        return array();
    }
    $vars          = array();
    $vars['alias'] = str_replace(':', '-', $segments[0]);
    $person_id     = preg_replace('#.*-(\d+)$#', '$1', $vars['alias']);

    $db = JFactory::getDBO();
    $query  = 'SELECT usr.id FROM #__users usr';
    $query .= ' JOIN `#__user_usergroup_map` ugmap ON usr.id = ugmap.user_id';
    $query .= ' JOIN `#__usergroups` ugp ON ugmap.group_id = ugp.id ';
    $query .= ' WHERE usr.id = '. (int) $person_id . ' AND usr.block = 0 AND ugp.title = "Staff"';

    $db->setQuery($query);
    $result = $db->loadObject();
    if (!$result) {
        JError::raiseError(404, JText::_("Page Not Found"));
    }

    $vars['id']   = $person_id;
    $vars['view'] = 'person';
    return $vars;
}