<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_people
 *
 * @copyright   Copyright (C) NPEU 2023.
 * @license     MIT License; see LICENSE.md
 */

namespace NPEU\Component\People\Site\Service;

defined('_JEXEC') or die;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Categories\CategoryFactoryInterface;
use Joomla\CMS\Categories\CategoryInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;
/**/use Joomla\CMS\MVC\Factory\MVCFactoryAwareTrait;
use Joomla\CMS\Menu\AbstractMenu;
use Joomla\CMS\Uri\Uri;
use Joomla\Database\DatabaseInterface;
use Joomla\Database\ParameterType;

use NPEU\Component\People\Site\Service\CustomRouterRules;



class Router extends RouterView
{
    use MVCFactoryAwareTrait;

    private $categoryFactory;

    private $categoryCache = [];

    private $db;

    /**
     * Component router constructor
     *
     * @param   SiteApplication           $app              The application object
     * @param   AbstractMenu              $menu             The menu object to work with
     * @param   CategoryFactoryInterface  $categoryFactory  The category object
     * @param   DatabaseInterface         $db               The database object
     */
    public function __construct(SiteApplication $app, AbstractMenu $menu)
    {
        //$this->categoryFactory = $categoryFactory;
        //$this->db              = $db;
        $this->db = \Joomla\CMS\Factory::getContainer()->get('DatabaseDriver');

        //$this->attachRule(new CustomRouterRules($this));

        #$category = new RouterViewConfiguration('category');
        #$category->setKey('id')->setNestable();
        #$this->registerView($category);
        $people = new RouterViewConfiguration('people');
        $people->addLayout('other');
        $this->registerView($people);

        $person = new RouterViewConfiguration('person');
        $person->setKey('id')->setParent($people);
        $this->registerView($person);

        /*$edit = new RouterViewConfiguration('edit');
        $edit->setParent($person);
        $this->registerView($edit);

        $alt = new RouterViewConfiguration('alt');
        $alt->setParent($people);
        $this->registerView($alt);

        $other = new RouterViewConfiguration('other');
        $other->setParent($people);
        $this->registerView($other);

        $add = new RouterViewConfiguration('add');
        $add->setParent($people);
        $this->registerView($add);*/

        //$this->attachRule(new CustomRouterRules($this));

        parent::__construct($app, $menu);

        $this->attachRule(new MenuRules($this));
        $this->attachRule(new StandardRules($this));
        $this->attachRule(new NomenuRules($this));

        #$this->attachRule(new CustomRouterRules($this));
    }

    /**
     * Method to get the id for an people item from the segment
     *
     * @param   string  $segment  Segment of the people to retrieve the ID for
     * @param   array   $query    The request that is parsed right now
     *
     * @return  mixed   The id of this item or false
     */
    public function getPersonId(string $segment, array $query): bool|int
    {
        // If the alias (segment) has been constructed to include the id as a
        // prefixed part of it, (e.g. 123-thing-name) then we can use this:
        //return (int) $segment;
        // Otherwise we'll need to query the data:

        $return = false;
        if (preg_match('#.*-(\d+)$#', $segment)) {
            $person_id = preg_replace('#.*-(\d+)$#', '$1', $segment);
            $base_url = Uri::base();
            $data     = json_decode(file_get_contents($base_url . 'data/staff?id=' . $person_id), true);
            $return   = (isset($data[0])) ? $person_id : false;
        }
        #echo 'getPersonId<pre>'; var_dump($return); echo '</pre>'; exit;
        return $return;

    }

    /**
     * Method to get the segment(s) for a people item
     *
     * @param   string  $id     ID of the people to retrieve the segments for
     * @param   array   $query  The request that is built right now
     *
     * @return  array|string  The segments of this item
     */
    public function getPersonSegment(int $id, array $query): array
    {
        #echo 'getPersonSegment<pre>'; var_dump($query); echo '</pre>';# exit;

        $db = $this->db;

        $dbQuery = $db->getQuery(true)
            ->select($db->quoteName('alias'))
            ->from($db->quoteName('#__people'))
            ->where($db->quoteName('id') . ' = :id')
            ->bind(':id', $id);

            $segment = $db->setQuery($dbQuery)->loadResult() ?: null;

        if ($segment === null) {
            return [];
        }
        return [$id => $segment];
    }

}
