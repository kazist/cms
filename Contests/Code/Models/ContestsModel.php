<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Contests\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\ BaseModel;
use Kazist\KazistFactory;
use Cms\Contests\Code\Classes\AccumulatePoints;
use Cms\Contests\Code\Classes\AssignPoints;
use Cms\Contests\Code\Classes\ContestWinner;
use Kazist\Service\Database\Query;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class ContestsModel extends BaseModel {

    public function getGeneralContest() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('cc.*');
        $query->from('#__cms_contests', 'cc');
        $query->where('cc.is_default=1');
        $query->andWhere('cc.published=1');



        $record = $query->loadObject();

        return $record;
    }

    public function getContestById($id) {

        $factory = new KazistFactory();



        $query = new Query();
        $query->select('cc.*');
        $query->from('#__cms_contests', 'cc');
        if ($id) {
            $query->where('cc.id=:id');
            $query->setParameter('id', $id);
        } else {
            $query->where('1=-1');
        }


        $record = $query->loadObject();

        return $record;
    }

    public function getContestList($target) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('cc.*');
        $query->from('#__cms_contests', 'cc');
        $query->where('cc.target=:target');
        $query->andWhere('cc.is_default=0 OR cc.is_default IS NULL');
        $query->andWhere('cc.published=1');
        $query->setParameter('target', $target);



        $records = $query->loadObjectList();

        return $records;
    }

    public function loadContestBlogs() {
        $paths = array();

        $object_arr = new \stdClass();
        $factory = new KazistFactory();



        $offset = $this->request->request->get('offset');
        $contest_id = $this->request->request->get('contest_id');

        $object_arr->offset = $offset;
        $object_arr->contest_id = $contest_id;

        $template = 'contest.blogs.twig';
        $this->twig_paths[] = JPATH_ROOT . '/applications/Cms/generalviews';

        $html = $factory->renderData($object_arr, $template, $paths);

        return $html;
    }

    public function accumulatePoints() {
        $accumulated_points = new AccumulatePoints();
        $accumulated_points->accumulatePoints();
    }

    public function assignPoints() {

        $assign_points = new AssignPoints();
        $assign_points->assignPoints();
    }

    public function contestWinner() {

        $contestwinner = new ContestWinner();
        $contestwinner->processWinners();
    }

}
