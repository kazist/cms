<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Blogs\Code\Models;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\Model\BaseModel;
use Kazist\KazistFactory;
use Cms\Contests\Code\Models\ContestsModel;
use Cms\Addons\LatestblogCode\Models\LatestblogModel;
use Search\Indexes\Code\Classes\ContentIndexing;
use Kazist\Service\Database\Query;
use Kazist\Service\Media\MediaManager;

/**
 * Description of MarketplaceModel
 *
 * @author sbc
 */
class BlogsModel extends BaseModel {

    public function appendSearchQuery($query) {


        $category_id = $this->request->get('category_id');

        $query = parent:: appendSearchQuery($query);

        if ($category_id) {
            $query->where('cb.category_id=' . $category_id);
        }

        $query->orderBy('cb.id ', 'DESC');

        return $query;
    }

    public function getRecord() {

        $where_arr = array();
        $parameter_arr = array();

        $slug = $this->request->get('slug');
        $id = ($id) ? $id : $this->request->get('id');

        $query = $this->getQueryBuilder();

        if ($id) {
            $where_arr[] = $this->table_alias . '.id=:id';
            $parameter_arr['id'] = $id;
        } elseif ($slug) {
            $where_arr[] = $this->table_alias . '.slug=:slug';
            $parameter_arr['slug'] = $slug;
        } else {
            $where_arr[] = '1=-1';
        }

        $this->addWhereToQuery($query, $where_arr, $parameter_arr);

        $record = $query->loadObject();

        $document = $this->container->get('document');
        $document->record_id = $record->id;

        return json_decode(json_encode($record));
    }

    //put your code here
    public function getAdditionalDetail($items) {

        $tmp_array = array();

        if (!empty($items)) {
            foreach ($items as $item) {
                $tmp_array[] = $this->getItemAdditionDetails($item);
            }
        }

        return $tmp_array;
    }

    public function getItemAdditionDetails($item) {

        $factory = new KazistFactory();

        $item_obj = (is_object($item)) ? $item : new \stdClass();

        $item_obj->title = ucwords($item->title);

        $item_obj->tallies = $this->getBlogContestTally($item->id);
        
        if ($item_obj->contest_id) {
            $item_obj->contest = $this->getBlogContest($item->contest_id);
        }

        return $item_obj;
    }

    public function getBlogContest($contest_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('cc.*');
        $query->from('#__cms_contests', 'cc');
        if ($contest_id) {
            $query->where('cc.id=:id');
            $query->setParameter('id', $contest_id);
        } else {
            $query->where('1=-1');
        }


        $record = $query->loadObject();

        return $record;
    }

    public function getBlogContestTally($blog_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('ccc.title, ccp.points, ccp.value');
        $query->from('#__cms_contests_points', 'ccp');
        $query->leftJoin('ccp', '#__cms_contests_criteria', 'ccc', 'ccp.criteria_id = ccc.id');

        if ($blog_id) {
            $query->where('ccp.blog_id=:blog_id');
            $query->setParameter('blog_id', $blog_id);
        } else {
            $query->where('1=-1');
        }



        $records = $query->loadObjectList();

        return $records;
    }

    public function getBlogImage($item) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('mm.file, mm.title');
        $query->from('#__cms_blogs', 'cb');
        $query->leftJoin('cb', '#__media_media', 'mm', 'mm.id = cb.image');
        if ($item->id) {
            $query->where('cb.id=:id');
            $query->setParameter('id', $item->id);
        } else {
            $query->where('1=-1');
        }


        $record = $query->loadObject();

        return $record;
    }

    public function saveContest($blog_id) {

        $data_obj = new \stdClass();
        $factory = new KazistFactory();
        $contestsModel = new ContestsModel();

        $blog = $this->getBlogById($blog_id);


        if ($blog->contest_id && ($blog->contest_start_date == '' || $blog->contest_start_date == '0000-00-00 00:00:00')) {

            $contest = $contestsModel->getContestById($blog->contest_id);

            $start_date = date('Y-m-d H:i:s');
            $end_date = date('Y-m-d H:i:s', strtotime('+' . $contest->no_of_days . ' days'));

            $data_obj->id = $blog_id;
            $data_obj->contest_start_date = $start_date;
            $data_obj->contest_end_date = $end_date;

            $factory->saveRecord('#__cms_blogs', $data_obj);
        }
    }

    public function save($form) {

        $factory = new KazistFactory();

        $blog_id = parent::save($form);

        $media_id = $this->saveImage($blog_id, $form);

        $this->saveContest($blog_id);

        if ($media_id) {
            $data = new \stdClass();
            $data->id = $blog_id;
            $data->image = $media_id;

            $factory->saveRecord('#__cms_blogs', $data);
        }

        return $blog_id;
    }

    public function saveImage($blog_id, $form) {

        $factory = new KazistFactory();

        $media_ids = $factory->uploadMedia('form.image', 'cms.blogs', $blog_id);

        return $media_ids[0];
    }

    public function getCategoriesOptions() {

        $tmp_array = array();
        $categories = $this->getCategories();

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $tmp_array[] = array('text' => $category->title, 'value' => $category->id);
            }
        }

        return $tmp_array;
    }

    public function getCategories() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('cbc.*');
        $query->from('#__cms_blogs_categories', 'cbc');
        $query->where('cbc.published=1');


        $record = $query->loadObjectList();

        return $record;
    }

    public function getBlogById($blog_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('cb.*');
        $query->from('#__cms_blogs', 'cb');
        if ($blog_id) {
            $query->where('cb.id=:id');
            $query->setParameter('id', $blog_id);
        } else {
            $query->where('1=-1');
        }


        $record = $query->loadObject();

        return $record;
    }

    public function getContestBlogs($contest_id, $offset = 0) {

        $limit = 10;

        $factory = new KazistFactory();


        $query = $factory->getQueryBuilder('#__cms_blogs', 'cb');
        $query->where('cb.contest_id=:contest_id');
        $query->setParameter('contest_id', $contest_id);

        $query->setFirstResult($offset);
        $query->setMaxResults($limit);

        $records = $query->loadObjectList();

        return $records;
    }

    public function getContestBlogsTotal($contest_id) {

        $factory = new KazistFactory();


        $query = $factory->getQueryBuilder('#__cms_blogs', 'cb');
        $query->select('COUNT(*) AS total');
        $query->where('cb.contest_id=:contest_id');
        $query->setParameter('contest_id', $contest_id);



        $record = $query->loadObject();

        if (is_object($record)) {
            return $record->total;
        } else {
            return false;
        }
    }

    public function loadCategoryBlogs() {

        $paths = array();

        $object_arr = new \stdClass();
        $factory = new KazistFactory();
        $latestblog_model = new LatestblogModel();



        $category_id = $this->request->request->get('category_id');

        $blogs = $latestblog_model->getBlogs($category_id);

        $object_arr->latest_blogs = $blogs[0];
        unset($blogs[0]);
        $object_arr->most_latest_blogs = $blogs;

        $template = 'category.blogs.twig';
        $paths[] = JPATH_ROOT . '/applications/Cms/Addons/Latestblog/views';

        $html = $factory->renderData($object_arr, $template, $paths);

        return $html;
    }

}
