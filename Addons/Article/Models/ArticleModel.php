<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Article\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class ArticleModel {

    public $block_id = '';

    public function getInfo() {
        return 'Hello World!';
    }

    public function getLatestArticles($category_id, $limit, $filter_type) {

        $factory = new KazistFactory;
        
        $query = $this->getQuery($category_id, $limit, $filter_type);

        $query->setFirstResult(0);
        $query->setMaxResults($limit);

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery($category_id, $limit, $filter_type) {

        $factory = new KazistFactory;

        $request = $factory->getRequest();

        $id = $request->request->get('id');


        $query = new Query();

        $query->select('ca.*, mm.file as article_image, uu.name as author_name');
        $query->from('#__cms_articles', 'ca');
        $query->leftJoin('ca', '#__media_media', 'mm', 'mm.id = ca.image');
        $query->leftJoin('ca', '#__users_users', 'uu', 'uu.id = ca.created_by');
        $query->where('ca.published=1');
        $query->andWhere('ca.image>0');

        switch ($filter_type) {
            case 'popular':
                $query->orderBy('ca.hit', 'DESC');
                break;
            case 'featured':
                $query->orderBy('ca.featured', 'DESC');
                break;
            case 'related':
                $article = $factory->getRecord('cms_articles', 'ca', array('id=:id'), array('id' => $id));
                $query->where('ca.category_id = :category_id');
                $query->setParameter('category_id', (int) $article->category_id);
                break;
            case 'latest':
            default:
                $query->orderBy('ca.date_created', 'DESC');
                break;
        }

        return $query;
    }

}
