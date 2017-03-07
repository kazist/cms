<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Columnist\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\AddonController;
use Cms\Addons\Columnist\Models\ColumnistModel;

/**
 * Kazist view class for the application
 *
 * @since  1.0
 */
class ColumnistController extends AddonController {

    function indexAction($offset = 0, $limit = 6) {

        $model = new ColumnistModel;

        $columnists = $model->getColumnists();

        $data_arr['columnists'] = $columnists;

        $this->html = $this->render('Cms:Addons:Columnist:views:columnist.twig', $data_arr);

        $response = $this->response($this->html);

        return $response;
    }

}
