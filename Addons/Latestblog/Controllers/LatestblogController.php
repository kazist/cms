<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Latestblog\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Controller\AddonController;
use Cms\Addons\Latestblog\Models\LatestblogModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class LatestblogController extends AddonController {

    public $flexview_id = '';

    function indexAction($offset = 0, $limit = 6) {

        $factory = new KazistFactory;
        $model = new LatestblogModel;

        $show_categories = $factory->getSetting('cms.block.latestblog.show.categories', $this->flexview_id);

        $model->flexview_id = $this->flexview_id;

        $categories = $model->getBlogCategories();
        $blogs = $model->getBlogs();

        //  $most_latest_blogs = $blogs[0];
        // unset($blogs[0]);
        $latest_blogs = $blogs;

        $data_arr['categories'] = $categories;
        $data_arr['latest_blogs'] = $latest_blogs;
        $data_arr['most_latest_blogs'] = $most_latest_blogs;
        $data_arr['show_categories'] = $show_categories;

        $this->html = $this->render('Cms:Addons:Latestblog:views:latestblog.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
