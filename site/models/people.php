<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_people
 *
 * @copyright   Copyright (C) NPEU 2019.
 * @license     MIT License; see LICENSE.md
 */

defined('_JEXEC') or die;

// Import the Joomla model library
jimport('joomla.application.component.model');

/**
 * People Model
 */
class PeopleModelPeople extends JModelLegacy
{
    public function getPeople()
    {
        $base_url = JUri::base();
        $data     = json_decode(file_get_contents($base_url . 'data/staff?collect=displaygroup&order=lastname'), true);

        // Exclude 'pseudo' members from list.
        // 608 = Maggie - not sure if I can just disable her account at this stage.
        $exclude = array(
            '608',
        );

        foreach ($data as $group_name => $group) {
            foreach ($group['people'] as $key => $person) {
                if (in_array($person['id'], $exclude)) {
                    unset($data[$group_name]['people'][$key]);
                }
            }
        }

        return $data;
    }
}