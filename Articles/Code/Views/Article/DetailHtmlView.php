<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Articles\Views\Article;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazicode\View\Detail\DetailHtmlView as GeneralDetailHtmlView;
use Kazicode\Service\KazistFactory;

/**
 * News HTML view class for the application
 *
 * @since  1.0
 */
class DetailHtmlView extends GeneralDetailHtmlView {

    public function prepare() {

        $factory = new KazistFactory();

        $rate_enable = $factory ->getSetting('cms_article_rate_enable');
        $addthis_enable = $factory ->getSetting('cms_article_addthis_enable');
        $disqus_enable = $factory ->getSetting('cms_article_disqus_enable');
        $survey_enable = $factory ->getSetting('cms_article_survey_enable');

        $extend_edit_dirs[] = JPATH_ROOT . '/applications/Cms/Components/Templates/';
        $this->renderer->addPath($extend_edit_dirs, true);

        // print_r($extend_edit_dirs); exit;

        parent::prepare();

        $item = $this->renderer->get('item');
        $item = $this->model->getItemAdditionDetails($item);

        $this->renderer->set('item', $item);
        $this->renderer->set('rate_enable', $rate_enable);
        $this->renderer->set('addthis_enable', $addthis_enable);
        $this->renderer->set('disqus_enable', $disqus_enable);
        $this->renderer->set('survey_enable', $survey_enable);
    }

}
