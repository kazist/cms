<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Latestblog\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class LatestblogModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getBlogs($category_id = '') {

        $factory = new KazistFactory;

        if (!$category_id) {
            $category_id = $factory->getSetting('cms.block.latestblog.category', $this->flexview_id);
        }

        $limit = $factory->getSetting('cms.block.latestblog.limit', $this->flexview_id);
        $new_limit = ($limit) ? $limit : 3;

        $query = new Query();
        $query->select('cb.*, mm.file as blog_image, uu.name as author_name');
        $query->from('#__cms_blogs', 'cb');
        $query->leftJoin('cb', '#__media_media', 'mm', 'mm.id = cb.image');
        $query->leftJoin('cb', '#__users_users', 'uu', 'uu.id = cb.created_by');

        $query->where('cb.image>0');

        if ((int) $category_id) {
            $query->andWhere('cb.category_id=:category_id');
            $query->setParameter('category_id', $category_id);
        }

        $query->andWhere('cb.published=1');
        $query->orderBy('cb.date_created', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults($new_limit);

        $records = $query->loadObjectList();

        //print_r($records); exit;
        return $records;
    }

    public function getBlogCategories() {


        $query = new Query();

        $query->select('cbc.*, COUNT(cb.id) AS counter');
        $query->from('#__cms_blogs_categories', 'cbc');
        $query->leftJoin('cbc', '#__cms_blogs', 'cb', 'cb.category_id = cbc.id');
        $query->groupBy('cb.category_id');
        $query->having('counter>4');
        $query->where('cbc.published=1');
        $query->orderBy('counter');
        $query->addOrderBy('cbc.title');

        $query->setFirstResult(0);
        $query->setMaxResults(8);

        $records = $query->loadObjectList();

        return $records;
    }

}
