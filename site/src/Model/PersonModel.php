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

use Joomla\CMS\Factory;
#use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;
#use NPEU\Component\People\Site\Helper\PersonHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Cache\CacheControllerFactoryInterface;
use Joomla\CMS\Uri\Uri;

/**
 * Person Component Model
 */
class PersonModel extends \Joomla\CMS\MVC\Model\BaseModel {

    public function getPerson()
    {
        $base_url = Uri::base();
        $data     = json_decode(file_get_contents($base_url . 'data/staff?id=' . $this->person_id), true);
        $return   = isset($data[0]) ? $data[0] : array();
        return $return;
    }
}