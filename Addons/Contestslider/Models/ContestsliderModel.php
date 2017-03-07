<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Contestslider\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class ContestsliderModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getContests() {

        $query = new Query();

        $query->select('cc.*, mm.file as contest_image');
        $query->from('#__cms_contests', 'cc');
        $query->leftJoin('cc', '#__media_media', 'mm', 'mm.id = cc.image');
        $query->where('(cc.default=0 OR cc.default IS NULL)');
        $query->andWhere('cc.published=1');
        $query->orderBy('cc.id ', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(10);

        $records = $query->loadObjectList();

        if (!empty($records)) {
            foreach ($records as $key => $record) {
                $records[$key]->blogs = $this->getContestBlogs($record->id);
                $records[$key]->total_blogs = $this->getContestTotalBlogs($record->id);
            }
        }



        return $records;
    }

    public function getContestBlogs($contest_id) {

        $query = new Query();

        $query->select('ca.*, mm.file as blog_image, uu.name as author_name');
        $query->from('#__cms_blogs', 'ca');
        $query->leftJoin('ca', '#__media_media', 'mm', ' mm.id = ca.image');
        $query->leftJoin('ca', '#__users_users', 'uu', ' uu.id = ca.created_by');
        $query->where('ca.contest_id=:contest_id');
        $query->setParameter('contest_id', $contest_id);
        $query->andWhere('ca.published=1');
        $query->orderBy('ca.id ', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(3);

        $records = $query->loadObjectList();

        return $records;
    }

    public function getContestTotalBlogs($contest_id) {

        $query = new Query();

        $query->select('COUNT(*) as total');
        $query->from('#__cms_blogs', 'ca');
        $query->leftJoin('ca', '#__media_media', 'mm', ' mm.id = ca.image');
        $query->leftJoin('ca', '#__users_users', 'uu', ' uu.id = ca.created_by');
        $query->where('ca.contest_id=:contest_id');
        $query->setParameter('contest_id', $contest_id);
        $query->andWhere('ca.published=1');
        $query->orderBy('ca.id ', 'DESC');

        $record = $query->loadObject();

        return $record->total;
    }

}
