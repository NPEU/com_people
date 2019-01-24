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
class PeopleModelPerson extends JModelLegacy
{
	public function getPerson()
	{
		$base_url = JUri::base();
		$data     = json_decode(file_get_contents($base_url . 'data/staff?id=' . $this->person_id), true);
		return $data[0];
	}
}