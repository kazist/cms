<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Menuarticle\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Cms\Articles\Code\Models\ArticlesModel;
use Kazist\Service\Database\Query;
use Kazist\Model\BaseModel;

class MenuarticleModel extends BaseModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getArticles() {

        $factory = new KazistFactory();
        $articleModel = new ArticlesModel();

        $query = $factory->getQueryBuilder('#__cms_articles', 'ca');

        $query->where('ca.published=1');
        $query->having('ca.image>0');
        $query->orderBy('ca.date_created ', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(7);

        $records = $query->loadObjectList();

        $records = $articleModel->getAdditionalDetail($records);

        return $records;
    }

    public function getCategories() {

        $factory = new KazistFactory();

        $query = $factory->getQueryBuilder('#__cms_articles_categories', 'cac');

        $query->where('cac.published=1');
        $query->having('cac.image>0');
        $query->orderBy('cac.date_created ', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(5);

        $records = $query->loadObjectList();


        return $records;
    }

}
