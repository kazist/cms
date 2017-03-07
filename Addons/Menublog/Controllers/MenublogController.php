<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Menublog\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Controller\AddonController;
use Cms\Addons\Menublog\Models\MenublogModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class MenublogController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $factory = new KazistFactory;
        $model = new MenublogModel;

        $blogs = $model->getBlogs();

        $data_arr['blogs'] = $blogs;

        $this->html = $this->render('Cms:Addons:Menublog:views:menublog.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
