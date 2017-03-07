<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Menuarticle\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Cms\Addons\Menuarticle\Models\MenuarticleModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class MenuarticleController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $this->model = new MenuarticleModel($this->container, $this->request);

        $data_arr['items'] = $this->model->getArticles();
        $data_arr['categories'] = $this->model->getCategories();

        $this->html = $this->render('Cms:Addons:Menuarticle:views:menuarticle.twig', $data_arr);

        $response = $this->response($this->html);

        return $response;
    }

}
