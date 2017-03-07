<?php

/*
 * This file is part of Kazist Framework.
 * (c) Dedan Irungu <irungudedan@gmail.com>
 *  For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 * 
 */

/**
 * Description of ArticlesController
 *
 * @author sbc
 */

namespace Cms\Articles\Code\Controllers;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Controller\BaseController;
use Cms\Articles\Code\Models\ArticlesModel;
use Kazist\KazistFactory;

class ArticlesController extends BaseController {

    public function indexAction($offset = 0, $limit = 10) {

        $this->model = new ArticlesModel();

        $category_id = $this->request->get('category_id');

        $items = $this->model->getRecords();
        $items = $this->model->getAdditionalDetail($items);
        $total = $this->model->getTotal();

        $data_arr['offset'] = $offset;
        $data_arr['limit'] = $limit;
        $data_arr['total'] = $total;
        $data_arr['items'] = $items;
        $data_arr['params'] = (!$category_id) ? array() : array('category_id'=> $category_id);

        $this->html = $this->render('Cms:Articles:Code:views:table.index.twig', $data_arr);

        $response = $this->response($this->html);

        return $response;
    }

    public function detailAction($id = '') {

        $factory = new KazistFactory();

        $rate_enable = $factory->getSetting('cms_article_rate_enable');
        $addthis_enable = $factory->getSetting('cms_article_addthis_enable');
        $disqus_enable = $factory->getSetting('cms_article_disqus_enable');
        $survey_enable = $factory->getSetting('cms_article_survey_enable');

        $this->twig_paths[] = JPATH_ROOT . 'applications/Cms/generalviews';

        $this->model = new ArticlesModel();

        $item = $this->model->getRecord();
        $this->model->saveHit($item);
        $item = $this->model->getItemAdditionDetails($item);

        $data_arr['item'] = $item;
        $data_arr['rate_enable'] = $rate_enable;
        $data_arr['addthis_enable'] = $addthis_enable;
        $data_arr['disqus_enable'] = $disqus_enable;
        $data_arr['survey_enable'] = $survey_enable;

        $this->container->get('document')->title = $item->title;
        $this->container->get('document')->description = ($item->short_description) ? $item->short_description : substr(strip_tags($item->article));
        $this->container->get('document')->image = WEB_ROOT . $item->image_file;
        $this->container->get('document')->type = 'article';

        $this->html = $this->render('Cms:Articles:Code:views:detail.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

    public function editAction() {

        $this->twig_paths[] = JPATH_ROOT . '/applications/Cms/generalviews/';

        $this->model = new ArticlesModel();

        $item = $this->model->getRecord();
        $item = $this->model->getItemAdditionDetails($item);
        $category_options = $this->model->getCategoriesOptions();

        $data_arr['item'] = $item;
        $data_arr['category_options'] = $category_options;

        $this->html = $this->render('Cms:Articles:Code:views:edit.index.twig', $data_arr);

        $response = $this->response($this->html);



        return $response;
    }

}
