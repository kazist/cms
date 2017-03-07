<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Menublog\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class MenublogModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getBlogs() {

        $factory = new KazistFactory();
        $db = $factory->getDbo();

        $query = $factory->getQueryBuilder('#__cms_blogs', 'cb');

        $query->where('cb.published=1');
        $query->having('image_file<>\'\'');
        $query->orderBy('cb.date_created ', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(4);

        $records = $query->loadObjectList();


        return $records;
    }

}
