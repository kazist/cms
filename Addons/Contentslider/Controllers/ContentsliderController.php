<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Contentslider\Controllers;

use Kazist\KazistFactory;
use Kazist\Controller\AddonController;
use Cms\Addons\Contentslider\Models\ContentsliderModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class ContentsliderController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $factory = new KazistFactory();

        $source = $factory->getSetting('cms.block.contentslider.source');
        $submission = $factory->getSetting('cms.block.contentslider.submission');

        $model = new ContentsliderModel;

        $model->source = $source;

        $categories = $model->getCategories();

        $data_arr['source'] = $source;
        $data_arr['categories'] = $categories;
        $data_arr['submission'] = $submission;

        $this->html = $this->render('Cms:Addons:Contentslider:views:contentslider.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
