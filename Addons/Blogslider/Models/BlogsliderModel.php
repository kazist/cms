<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Blogslider\Models;

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class BlogsliderModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getLatestBlogs() {

        $query = $this->getQuery();

        $query->setFirstResult(1);
        $query->setMaxResults(8);

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery() {

        $query = new Query();
        $query->select('ca.*, mm.file AS blog_image, uu.name AS author_name, cbc.title AS category_title');
        $query->from('#__cms_blogs', 'ca');
        $query->leftJoin('ca', '#__cms_blogs_categories', 'cbc', ' ca.category_id = cbc.id');
        $query->leftJoin('ca', '#__media_media', 'mm', ' mm.id = ca.image');
        $query->leftJoin('ca', '#__users_users', 'uu', ' uu.id = ca.created_by');
        $query->where('ca.published=1');
        $query->andWhere('ca.image>0');
        $query->orderBy('ca.id', 'DESC');

        return $query;
    }

}
