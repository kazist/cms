<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Blogslider\Controllers;

use Kazist\Controller\AddonController;
use Cms\Addons\Blogslider\Models\BlogsliderModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class BlogsliderController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $slider_limit = 6;

        $model = new BlogsliderModel;

        $blogs = $model->getLatestBlogs();

        $data_arr['blogs'] = $blogs;
        $data_arr['slider_limit'] = $slider_limit;

        $this->html = $this->render('Cms:Addons:Blogslider:views:blogslider.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
