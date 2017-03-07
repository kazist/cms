<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Slider\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Cms\Addons\Slider\Models\SliderModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class SliderController extends AddonController {

    public $flexview_id = 0;

    function indexAction($category_id = 0, $width = 700, $height = 300, $show_indicator = true, $show_caption = true) {

        $model = new SliderModel;

        $sliders = $model->getSliders();

        $data_arr['show_indicator'] = $show_indicator;
        $data_arr['show_caption'] = $show_caption;
        $data_arr['sliders'] = $sliders;
        $data_arr['width'] = $width;
        $data_arr['height'] = $height;

        $this->html = $this->render('Cms:Addons:Slider:views:slider.twig', $data_arr);

        $response = $this->response($this->html);

        return $response;
    }

}
