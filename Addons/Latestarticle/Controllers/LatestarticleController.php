<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Latestarticle\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Cms\Addons\Latestarticle\Models\LatestarticleModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class LatestarticleController extends AddonController {

    public $flexview_id = '';

    function indexAction($category_id = 1, $limit = 6) {

        $model = new LatestarticleModel;

        $model->flexview_id = $this->flexview_id;

        $articles = $model->getArticles($category_id, $limit);
        $article_category = $model->getLatestArticleCategory($category_id);

        $latest_articles = $articles;

        $data_arr['article_category'] = $article_category;
        $data_arr['latest_articles'] = $latest_articles;

        $this->html = $this->render('Cms:Addons:Latestarticle:views:latestarticle.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
