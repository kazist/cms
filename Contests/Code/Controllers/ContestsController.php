<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of ContestsController
 *
 * @author sbc
 */

namespace Cms\Contests\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\BaseController;

class ContestsController extends BaseController {

    function assignpointscronAction() {

        $this->model->assignPoints();
        echo 'Completed';

        exit;
    }

    function accumulatepointscronAction() {

        $this->model->accumulatePoints();
        echo 'Completed';

        exit;
    }

    function winnerpointsAction() {

        $this->model->contestWinner();
        echo 'Completed';

        exit;
    }

}
