<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Blog\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class BlogModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getLatestBlogs() {

        $query = $this->getQuery();

        $query->setFirstResult(0);
        $query->setMaxResults(3);

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery() {

        $query = new Query();

        $query->select('ca.*, mm.file as blog_image, uu.name as author_name');
        $query->from('#__cms_blogs', 'ca');
        $query->leftJoin('ca', '#__media_media', 'mm', 'mm.id = ca.image');
        $query->leftJoin('ca', '#__users_users', 'uu', 'uu.id = ca.created_by');
        $query->where('ca.published=1');
        $query->andWhere('ca.image>0');
        $query->orderBy('ca.id', 'DESC');
        
        return $query;
    }

}
