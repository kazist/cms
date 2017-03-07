<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Blogs\Code\Classes;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Email\Email;
use Kazist\Service\Database\Query;

/* * publishedpublished
 * Description of AccumulatePoints
 *
 * @author sbc
  s */

class Author {

    public $certificate_file = '';

    public function getAuthor() {

        global $sc;

        $factory = new KazistFactory();

        $document = $sc->get('document');
        $user = $document->user;
        $user_id = $user->id;

        $record = $factory->getRecord('#__users_users', 'uu', array('uu.user_id=:user_id'), array('user_id' => $user_id));

        print_r($record); exit;
        
        return $record;
    }

}
