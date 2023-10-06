<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_people
 *
 * @copyright   Copyright (C) NPEU 2023.
 * @license     MIT License; see LICENSE.md
 */

namespace NPEU\Component\People\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;

/**
 * Person Component Model
 */
class PeopleModel extends \Joomla\CMS\MVC\Model\BaseModel {

    public function getPeople()
    {
        $base_url = Uri::base();
        $data     = json_decode(file_get_contents($base_url . 'data/staff?collect=displaygroup&order=lastname&basic=1'), true);

        // Exclude 'pseudo' members from list.
        // @TODO - this should come from admin config really...
        $exclude = [];

        if (is_array($data)) {
            foreach ($data as $group_name => $group) {
                if ($group['length'] > 0) {
                    foreach ($group['people'] as $key => $person) {
                        if (in_array($person['id'], $exclude)) {
                            unset($data[$group_name]['people'][$key]);
                        }
                    }
                }
            }
        } else {
            $data = array();
        }

        return $data;
    }

}