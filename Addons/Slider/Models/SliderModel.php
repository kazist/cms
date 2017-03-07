<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Addons\Slider\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

class SliderModel {

    public function getInfo() {
        return 'Hello World!';
    }

    public function getShowIndicator($block_id) {

        $factory = new KazistFactory();

        $show_indicator = $factory->getSetting('cms_slider_block_slider_show_indicator', $block_id);

        return $show_indicator;
    }

    public function getShowCaption($block_id) {

        $factory = new KazistFactory();

        $show_caption = $factory->getSetting('cms_slider_block_slider_show_caption', $block_id);

        return $show_caption;
    }

    public function getHeight($block_id) {

        $factory = new KazistFactory();

        $height = $factory->getSetting('cms_slider_block_slider_height', $block_id);

        return ($height) ? $height : 400;
    }

    public function getWidth($block_id) {

        $factory = new KazistFactory();

        $width = $factory->getSetting('cms_slider_block_slider_width', $block_id);

        return ($width) ? $width : 1100;
    }

    public function getSliders() {

        $query = $this->getQuery();

        $records = $query->loadObjectList();

        return $records;
    }

    public function getQuery() {

        $query = new Query();

        $query->select('s.*, mm.file as slider_image');
        $query->from('#__cms_sliders', 's');
        $query->leftJoin('s', '#__media_media', 'mm', 'mm.id = s.image');
        $query->where('s.published=1');
        $query->orderBy('s.id', 'DESC');

        return $query;
    }

}
