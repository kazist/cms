<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Article\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Cms\Addons\Article\Models\ArticleModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class ArticleController extends AddonController {

    public $flexview_id = '';

    function indexAction($category_id = 1, $limit = 6, $filter_type = 'popular', $template = 'tabular', $additional_info = true) {

        $model = new ArticleModel;

        $articles = $model->getLatestArticles($category_id, $limit, $filter_type, $additional_info);

        $data_arr['template'] = $template;
        $data_arr['articles'] = $articles;
        $data_arr['additional_info'] = $additional_info;

        $this->html = $this->render('Cms:Addons:Article:views:article.twig', $data_arr);

        $response = $this->response($this->html);

        return $response;
    }

}
