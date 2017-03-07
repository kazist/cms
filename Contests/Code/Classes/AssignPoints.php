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
 * Description of Assign
 *
 * @author sbc
 */
class AssignPoints {

    public $arrjson = array();
    public $total_value = 0;
    public $total_points = 0;

    function assignPoints() {

        $factory = new KazistFactory();

        $blogs = $this->getBlogs();

        if (!empty($blogs)) {
            foreach ($blogs as $key => $blog) {

                $this->processContestPoints($blog);

                $stdobject = new \stdClass();
                $stdobject->id = $blog->id;
                $stdobject->point_counted = 1;

                $factory->saveRecord('#__cms_blogs', $stdobject);
            }
        } else {

            $query = new Query();
            $query->update('#__cms_blogs');
            $query->set('point_counted', '0');
            $query->where('contest_end_date > now()');

            $query->execute();
        }
    }

    function processContestPoints($blog) {

        $criterias = $this->getContestCriterias();

        if (!empty($criterias)) {
            foreach ($criterias as $criteria) {
                $function_name = $criteria->alias;

                if (method_exists($this, $function_name)) {
                    $this->$function_name($blog, $criteria->id);
                }
            }
        }
    }

    function getContestCriterias() {
        $factory = new KazistFactory();


        $query = new Query();
        $query->select('ccc.*');
        $query->from('#__cms_contests_criteria', 'ccc');

        $records = $query->loadObjectList();

        return $records;
    }

    function getBlogs() {
        $factory = new KazistFactory();


        $query = new Query();
        $query->select('cb.*, cc.no_of_days, cc.start_date, cc.end_date');
        $query->from('#__cms_blogs', 'cb');
        $query->leftJoin('cb', '#__cms_contests', 'cc', 'cc.id = cb.contest_id');
        $query->where('(cb.point_counted=0 OR cb.point_counted IS NULL)');
        $query->orderBy('cb.contest_id', 'DESC');
        $query->setFirstResult(0);
        $query->setMaxResults(50);

        $records = $query->loadObjectList();

        return $records;
    }

    function addBlogValue($value, $blog_id, $criteria_id) {

        $stdobject = new \stdClass();
        $factory = new KazistFactory();

        $stdobject->blog_id = $blog_id;
        $stdobject->criteria_id = $criteria_id;
        $stdobject->value = $value;

        $blogcontestvalueexist = $this->checkBlogValueExist($blog_id, $criteria_id);

        $stdobject->id = ($blogcontestvalueexist) ? $blogcontestvalueexist : '';

        $factory->saveRecord('#__cms_contests_points', $stdobject);
    }

    function checkBlogValueExist($blog_id, $criteria_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('ccp.*');
        $query->from('#__cms_contests_points', 'ccp');
        $query->where('ccp.criteria_id=:criteria_id');
        $query->andWhere('ccp.blog_id=:blog_id');
        $query->setParameter('criteria_id', $criteria_id);
        $query->setParameter('blog_id', $blog_id);


        $record = $query->loadObject();

        if (is_object($record)) {
            return $record->id;
        } else {
            return false;
        }
    }

    function updateRecords($value, $blog, $criteria_id) {

        $contest_id = $blog->contest_id;
        $blog_id = $blog->id;
        $no_days = $blog->no_of_days;
        
        if ($blog->contest_end_date <> '' && !$blog->contest_closed) {
            $date = new \DateTime($blog->contest_end_date);
            $date->add(new \DateInterval('P' . $no_days . 'D'));
            $contest_date = $date->getTimestamp();

            if ($contest_id && $contest_date > time()) {
                $this->addBlogValue($value, $blog_id, $criteria_id);
            }
        } else {
            $this->addBlogValue($value, $blog_id, $criteria_id);
        }
    }

    function facebook_share($blog, $criteria_id) {

        $blog_url = $this->getUrl($blog);

        //$blog_url = 'http://www.stackoverflow.com';
        $query_url = 'http://graph.facebook.com/?ids=' . $blog_url;
        $response = $this->getCurlContent($query_url);
        $response = json_decode($response, true);

        $value = (isset($response[$blog_url]['shares'])) ? $response[$blog_url]['shares'] : 0;

        $this->updateRecords($value, $blog, $criteria_id);
    }

    function facebook_like($blog, $contest_point_id) {

        $blog_url = $this->getUrl($blog);
        $query_url = 'http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls="' . $blog_url . '"';

        $response = $this->getCurlContent($query_url);
        $response = json_decode($response, true);

        $value = (isset($response[0]['like_count'])) ? $response[0]['like_count'] : 0;

        $this->updateRecords($value, $blog, $contest_point_id);
    }

    function twitter_share($blog, $contest_point_id) {

        $blog_url = $this->getUrl($blog);
        $query_url = 'http://urls.api.twitter.com/1/urls/count.json?url=' . $blog_url;
        $response = $this->getCurlContent($query_url);
        $response = json_decode($response, true);

        $value = (isset($response['count'])) ? $response['count'] : 0;

        $this->updateRecords($value, $blog, $contest_point_id);
    }

    function disqus_comments($blog, $contest_point_id) {

        $value = $blog->comments;

        $this->updateRecords($value, $blog, $contest_point_id);
    }

    function page_views($blog, $contest_point_id) {

        $value = $blog->hit;

        $this->updateRecords($value, $blog, $contest_point_id);
    }

    function count_images($blog, $contest_point_id) {

        $contents = $blog->text;
        $count = preg_match_all("@<img [^>]+>@", $contents, $matches);

        $value = $count;

        $this->updateRecords($value, $blog, $contest_point_id);
    }

    function getCurlContent($url) {

        $curl = curl_init();
// Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Jobads4Free'
        ));
// Send the request & save response to $resp
        $resp = curl_exec($curl);
        // print_r($url); exit;
// Close request to clear up some resources
        curl_close($curl);

        return $resp;
    }

    public function getUrl($blog) {

        $factory = new KazistFactory();

        $url = $factory->generateUrl('cms.blogs.detail', array('id', $blog->id));

        return $url;
    }

}
