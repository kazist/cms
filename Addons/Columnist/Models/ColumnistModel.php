<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Columnist\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class ColumnistModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getColumnists() {
        $tmp_array = array();
        $factory = new KazistFactory();

        $query = $factory->getQueryBuilder('#__cms_blogs_columnists', 'cbc');
        $query->setFirstResult(0);
        $query->setMaxResults(6);

        $records = $query->loadObjectList();


        foreach ($records as $key => $record) {
            $user = $factory->getRecord('#__users_users', 'uu', array('id=:id'), array('id' => $record->user_id));

            $user->blogs = $this->getBlogs($record->user_id);
     
            $tmp_array[] = $user;
        }

        return $tmp_array;
    }

    public function getBlogs($user_id) {

        $factory = new KazistFactory();

        $query = $factory->getQueryBuilder('#__cms_blogs', 'bc', array('created_by=:created_by'), array('created_by' => $user_id));
        $query->orderBy('id', 'DESC');
        $query->setFirstResult(0);
        $query->setMaxResults(2);

        $records = $query->loadObjectList();

        return $records;
    }

}
