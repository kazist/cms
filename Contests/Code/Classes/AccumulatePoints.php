<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Contests\Code\Classes;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Database\Query;

/**
 * Description of AccumulatePoints
 *
 * @author sbc
 */
class AccumulatePoints {

    //put your code here
    function accumulatePoints() {

        $factory = new KazistFactory();

        $blogs = $this->getAccumulateBlogs();


        if (!empty($blogs)) {
            foreach ($blogs as $key => $blog) {

                $time = time();
                $date = new \DateTime($blog->contest_end_date);
                $date->add(new \DateInterval('P' . $blog->no_of_days . 'D'));
                $end_time = $date->getTimestamp();

                if ($end_time < $time) {

                    $this->processAccumulatedPoints($blog);

                    $stdobject = new \stdClass();
                    $stdobject->id = $blog->id;
                    $stdobject->point_accumulated = 1;
                 
                    $factory->saveRecord('#__cms_blogs', $stdobject);
                }
            }
        }
    }

    function getAccumulateBlogs() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('b.*, cc.no_of_days');
        $query->from('#__cms_blogs', 'b');
        $query->leftJoin('b', '#__cms_contests', 'cc', 'cc.id = b.contest_id');
        $query->where('(b.point_accumulated=0 OR b.point_accumulated IS NULL)');
        $query->andWhere('b.contest_id>0');
        $query->andWhere('b.contest_end_date < now()');
        $query->setFirstResult(0);
        $query->setMaxResults(50);

        $records = $query->loadObjectList();

        return $records;
    }

    function processAccumulatedPoints($blog) {

        $criterias = $this->getContestCriterias();

        $this->total_value = 0;
        $this->total_points = 0;
        $this->arrjson = array();

        foreach ($criterias as $criteria) {
            $this->updateBlogPoints($blog, $criteria);
        }

        $contest_season = $this->getContestSeason($blog);

        $this->updateBlogContest($blog, $contest_season);
        $this->updateContestWinner($blog, $contest_season);
    }

    function updateBlogContest($blog, $contest_season) {

        $factory = new KazistFactory();


        $stdclass = new \stdClass();
        $stdclass->id = $blog->id;
        $stdclass->contest_closed = 1;
        $stdclass->contest_season = $contest_season;

        $factory->saveRecord('#__cms_blogs', $stdclass);
    }

    function updateContestWinner($blog, $contest_season) {

        $factory = new KazistFactory();
        $stdclass = new \stdClass();

        $stdclass->blog_id = $blog->id;
        $stdclass->category_id = $blog->category_id;
        $stdclass->user_id = $blog->created_by;
        $stdclass->contest_id = $blog->contest_id;
        $stdclass->contest_season = $contest_season;
        $exist_obj = clone $stdclass;
        $stdclass->properties = json_encode($this->arrjson);
        $stdclass->total_points = $this->total_points;
        $stdclass->total_values = $this->total_value;

        $where_arr = array();
        $where_arr[] = 'blog_id=:blog_id';
        $where_arr[] = 'category_id=:category_id';
        $where_arr[] = 'user_id=:user_id';
        $where_arr[] = 'contest_id=:contest_id';
        $where_arr[] = 'contest_season=:contest_season';

        $factory->saveRecord('#__cms_contests_results', $stdclass, $where_arr, $exist_obj);
       
    }

    function updateBlogPoints($blog, $criteria) {

        $factory = new KazistFactory();

        $user = $factory->getUser();

        $blog_points = $this->getBlogContestPoint($blog, $criteria);

        $value = $blog_points->value; // - $blog_points->original_value;
        $min_points = $criteria->min_points;
        $max_points = $criteria->max_points;
        $top_value = $this->getContestSumationPoints($blog, $criteria);

        if ($top_value < 1 || $value < 1) {
            $points = 0;
        } else {
            $points = round($value / $top_value * $max_points);
        }
        $points = ($points <= $min_points) ? $min_points : $points;

        $this->total_value += $value;
        $this->total_points += $points;

        $stdclass = new \stdClass();
        $stdclass->blog_id = $blog->id;
        $stdclass->criteria_id = $criteria->id;
        $exist_obj = clone $stdclass;
        $stdclass->points = $points;

        $where_arr = array();
        $where_arr[] = 'blog_id=:blog_id';
        $where_arr[] = 'criteria_id=:criteria_id';

        $factory->saveRecord('#__cms_contests_points', $stdclass, $where_arr, $exist_obj);

        $this->prepareContestPointObject($value, $points, $criteria);
    }

    function prepareContestPointObject($value, $points, $criteria) {

        $stdjson = new \stdClass();

        $stdjson->title = $criteria->title;
        $stdjson->action_name = $criteria->action_name;
        $stdjson->value = $value;
        $stdjson->points = $points;
        $stdjson->action_name = $criteria->action_name;
        $stdjson->min_points = $criteria->min_points;
        $stdjson->max_points = $criteria->max_points;

        $this->arrjson[$stdjson->action_name] = $stdjson;
    }

    function getContestCriterias() {
        $factory = new KazistFactory();


        $query = new Query();
        $query->select('ccc.*');
        $query->from('#__cms_contests_criteria', 'ccc');

        $records = $query->loadObjectList();

        return $records;
    }

    function getBlogContestPoint($blog, $criteria) {
        $factory = new KazistFactory();


        $query = new Query();
        $query->select('ccp.*');
        $query->from('#__cms_contests_points', 'ccp');
        $query->where('ccp.criteria_id=:criteria_id');
        $query->andWhere('ccp.blog_id=:blog_id');
        $query->setParameter('criteria_id', $criteria->id);
        $query->setParameter('blog_id', $blog->id);
        $query->orderBy('value ', 'DESC');


        $record = $query->loadObject();

        return $record;
    }

    function getContestSumationPoints($blog, $criteria) {
        $factory = new KazistFactory();


        $query = new Query();
        $query->select('value');
        $query->from('#__cms_contests_points', 'ccp');
        $query->where('ccp.criteria_id=:criteria_id');
        $query->andWhere('ccp.blog_id=:blog_id');
        $query->setParameter('criteria_id', $criteria->id);
        $query->setParameter('blog_id', $blog->id);
        $query->orderBy('value ', 'DESC');


        $value = $query->loadResult();

        return $value;
    }

    function getContestSeason($blog) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('cc.*');
        $query->from('#__cms_contests', 'cc');
        $query->where('cc.id=:id');
        $query->setParameter('id', $blog->contest_id);


        $record = $query->loadObject();

        $start_time = $record->publish_up;
        $end_time = $blog->start_time;

        $start_timestamp = strtotime($start_time);
        $end_timestamp = strtotime($end_time);

        $time_diff_days = abs(($end_timestamp - $start_timestamp) / (60 * 60 * 24));

        $contest_season = ceil($time_diff_days / $record->no_of_days);

        return ($contest_season) ? $contest_season : 1;
    }

}
