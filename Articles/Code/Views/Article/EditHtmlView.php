<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Articles\Views\Article;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazicode\View\Edit\EditHtmlView as GeneralEditHtmlView;

/**
 * News HTML view class for the application
 *
 * @since  1.0
 */
class EditHtmlView extends GeneralEditHtmlView {

    public function prepare() {

        $extend_edit_dirs[] = JPATH_ROOT . '/applications/Cms/Components/Templates/';
        $this->renderer->addPath($extend_edit_dirs, true);

        parent::prepare();

        $item = $this->renderer->get('item');
        $item = $this->model->getItemAdditionDetails($item);
        $category_options = $this->model->getCategoriesOptions();

        $this->renderer->set('item', $item);
        $this->renderer->set('category_options', $category_options);
    }

}
