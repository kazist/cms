<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Articlecategory\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class ArticlecategoryModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getArticleCategory() {

        $query = $this->getQuery();

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery() {

        $factory = new KazistFactory();

        $where_arr = array('cac.published=1');
        $order_arr = array('cac.id' => 'DESC');

        $query = $factory->getQueryBuilder('#__cms_articles_categories', 'cac', $where_arr, null, $order_arr);
        
        return $query;
    }

}
