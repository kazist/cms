<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Blogcategory\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class BlogcategoryModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getArticleCategory() {


        $query = $this->getQuery();

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery() {

        $query = new Query();
        $query->select('cac.*');
        $query->from('#__cms_blogs_categories', 'cac');
        $query->where('cac.published=1');
        $query->orderBy('cac.id ', 'DESC');

        return $query;
    }

}
