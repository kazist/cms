<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Contestslider\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Cms\Addons\Contestslider\Models\ContestsliderModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class ContestsliderController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new ContestsliderModel;

        $contests = $model->getContests();

        $data_arr['contests'] = $contests;

        $this->html = $this->render('Cms:Addons:Contestslider:views:contestslider.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
