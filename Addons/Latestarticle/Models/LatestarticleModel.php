<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Latestarticle\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class LatestarticleModel {

    public $block_id = '';

    public function getInfo() {
        return 'Hello World!';
    }

    public function getArticles($category_id, $limit) {

        $factory = new KazistFactory;


        $new_limit = ($limit) ? $limit : 3;

        $query = new Query();
        $query->select('ca.*, mm.file as article_image, uu.name as author_name');
        $query->from('#__cms_articles', 'ca');
        $query->leftJoin('ca', '#__media_media', 'mm', 'mm.id = ca.image');
        $query->leftJoin('ca', '#__users_users', 'uu', 'uu.id = ca.created_by');

        $query->where('ca.image>0');
        $query->andWhere('ca.published=1');
        if ((int) $category_id) {
            $query->andWhere('ca.category_id=:category_id');
            $query->setParameter('category_id', $category_id);
        }

        $query->orderBy('ca.date_created ', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults($new_limit);

        $records = $query->loadObjectList();

        return $records;
    }

    public function getLatestArticleCategory($category_id) {

        $factory = new KazistFactory;

        $query = new Query();
        $query->select('cac.*');
        $query->from('#__cms_articles_categories', 'cac');

        if ((int) $category_id) {
            $query->where('cac.id=:category_id');
            $query->setParameter('category_id', $category_id);
        } else {
            $query->where('1=-1');
        }

        $record = $query->loadObject();

        return $record;
    }

}
