<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Blog\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Cms\Addons\Blog\Models\BlogModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class BlogController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new BlogModel;

        $blogs = $model->getLatestBlogs();

        $data_arr['blogs'] = $blogs;

        $this->html = $this->render('Cms:Addons:Blog:views:blog.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
