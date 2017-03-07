<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Contentslider\Models;

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class ContentsliderModel {

    public $source = 'blogs';

    public function getInfo() {
        return 'Hello World!';
    }

    public function getCategories() {

        if ($this->source == '') {
            return false;
        }

        $query = new Query();

        $query->select('cc.*, mm.file as content_image');
        $query->from('#__cms_' . $this->source . '_categories', 'cc');
        $query->leftJoin('cc', '#__media_media', 'mm', 'mm.id = cc.image');
        $query->where('cc.published=1');
        $query->andWhere('cc.featured=1');
        $query->orderBy('cc.id', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(10);

        $records = $query->loadObjectList();

        if (!empty($records)) {
            foreach ($records as $key => $record) {
                $records[$key]->contents = $this->getCategoriesContents($record->id);
                $records[$key]->total_contents = $this->getCategoryTotalContents($record->id);
            }
        }

        return $records;
    }

    public function getCategoriesContents($category_id) {

        if ($this->source == '') {
            return false;
        }

        $query = new Query();

        $query->select('cc.*, mm.file as content_image, uu.name as author_name');
        $query->from('#__cms_' . $this->source, 'cc');
        $query->leftJoin('cc', '#__media_media', 'mm', 'mm.id = cc.image');
        $query->leftJoin('cc', '#__users_users', 'uu', 'uu.id = cc.created_by');
        $query->where('cc.category_id=:category_id');
        $query->setParameter('category_id', $category_id);
        $query->andWhere('cc.published=1');
        $query->orderBy('cc.id', 'DESC');

        $query->setFirstResult(0);
        $query->setMaxResults(3);

        $records = $query->loadObjectList();

        return $records;
    }

    public function getCategoryTotalContents($category_id) {

        $query = new Query();

        $query->select('COUNT(*) as total');
        $query->from('#__cms_' . $this->source, 'cc');
        $query->leftJoin('cc', '#__users_users', 'uu', 'uu.id = cc.created_by');
        $query->where('cc.category_id=:category_id');
        $query->setParameter('category_id', $category_id);
        $query->andWhere('cc.published=1');
        $query->orderBy('cc.id ', 'DESC');

        $record = $query->loadObject();

        return $record->total;
    }

}
