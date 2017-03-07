<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Articlecategory\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Cms\Addons\Articlecategory\Models\ArticlecategoryModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class ArticlecategoryController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new ArticlecategoryModel;

        $categories = $model->getArticleCategory();

        $data_arr['categories'] = $categories;

        $this->html = $this->render('Cms:Addons:Articlecategory:views:articlecategory.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
