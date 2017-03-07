<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cms\Contests\Code\Classes;

defined('KAZIST') or exit('Not Kazist Framework');

use Kazist\KazistFactory;
use Kazist\Service\Email\Email;
use Kazist\Service\Database\Query;

/* * publishedpublished
 * Description of AccumulatePoints
 *
 * @author sbc
  s */

class ContestWinner {

    public $certificate_file = '';

    public function processWinners() {

        $factory = new KazistFactory();
        $contests = $this->getContests();

        if (!empty($contests)) {
            foreach ($contests as $key => $contest) {

                $valid = $this->checkContestValidity($contest);

                if ($valid) {
                    $this->processContestSeasons($contest);
                } else {
                    $data_obj = new \stdClass();
                    $data_obj->id = $contest->id;
                    $data_obj->closed = 1;

                    $factory->saveRecord('#__cms_blogs_contests', $data_obj);
                }
            }
        }
    }

    private function checkContestValidity($contest) {

        $is_valid = false;

        if ($contest->end_date == '' || $contest->end_date == '0000-00-00 00:00:00') {
            $is_valid = true;
        } else {

            $time = time();
            $date = new \DateTime($contest->end_date);
            $date->add(new \DateInterval('P' . $contest->no_of_days . 'D'));
            $end_time = $date->getTimestamp();

            $is_valid = ($end_time > $time) ? true : false;
        }


        return $is_valid;
    }

    public function processContestSeasons($contest) {

        $start_date = $contest->start_date;
        $start_date_stamp = strtotime($start_date);
        $today_stamp = time();

        $period_stamp = 24 * 60 * 60 * $contest->no_of_days;

        $seasons = floor(($today_stamp - $start_date_stamp) / $period_stamp);

        if ($seasons) {
            for ($i = 1; $i <= $seasons; $i++) {
                $season_no = $i;
                $this->processContestSeason($contest, $season_no);
            }
        }
    }

    public function processContestSeason($contest, $season_no) {

        $winner = $this->getContestWinner($contest->id, $season_no);

        if (!is_object($winner)) {
            $this->processContestWinner($contest, $season_no);
        }
    }

    public function processContestWinner($contest, $season_no) {

        $result_winner = $this->getTopContestResult($contest->id, $season_no);

        $this->winnerCertificate($result_winner);
        $this->sendEmail($result_winner);
        $this->saveContestWinner($result_winner);
    }

    private function saveContestWinner($result_winner) {

        $factory = new KazistFactory();

        unset($result_winner->date_modified);
        unset($result_winner->date_created);
        unset($result_winner->created_by);
        unset($result_winner->modified_by);
        unset($result_winner->id);

        $factory->saveRecord('#__cms_contests_winners', $result_winner);
    }

    public function winnerCertificate($result_winner) {

        global $sc;

        $factory = new KazistFactory();

        $user = $factory->getRecord('#__users_users', 'uu', array('id=:id'), array('id' => $result_winner->user_id));
        $contest = $this->getContestById($result_winner->contest_id);
        $system_title = $sc->getParameter('system.title');
  
        $user_full_name = $user->name;
        $user_name = $user->username;
        $blog_contest_name = $contest->title;
        $signature = 'Ross';
        $certificate_folder = JPATH_ROOT . '/uploads/cms/contest/certificates/' . $result_winner->contest_id . '/';
        $certificate_name = $certificate_folder . $user_name . '-certificate.pdf';
        $this->certificate_file = $certificate_name;

        require_once(JPATH_ROOT . '/applications/Cms/Contests/Code/Classes/Certificate.php');
        $custom_layout = array(210, 150);

        // create new PDF document
        $pdf = new \CertificatePDF('L', PDF_UNIT, $custom_layout, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($system_title);
        $pdf->SetTitle($system_title . ' Contest Winner Certificate');
        $pdf->SetSubject($system_title . ' Contest Winner Certificate');
        $pdf->SetKeywords($system_title . ', Blog, Contest, Winner, Certificate');


        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        // remove default footer
        $pdf->setPrintFooter(false);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('times', '', 16);

        // add a page
        $pdf->AddPage();

        // Print a text
        $html = '<span style="color:blue; text-align:center;">&nbsp;' . $user_full_name . '&nbsp;</span>';
        $pdf->SetXY(0, 67);
        $pdf->writeHTML($html, true, false, true, false, '');
        // Print a text
        $pdf->SetFont('times', '', 12);
        $html = '<span style="color:blue; text-align:center;">&nbsp; Blog Contest In;  "' . $blog_contest_name . '" &nbsp;</span>';
        $pdf->SetXY(0, 88);
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '<span style="color:blue;">&nbsp; ' . date('dS') . ' &nbsp;</span>';
        $pdf->SetXY(55, 103);
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '<span style="color:blue;">&nbsp; ' . date('M') . ' &nbsp;</span>';
        $pdf->SetXY(90, 103);
        $pdf->writeHTML($html, true, false, true, false, '');

        $html = '<span style="color:blue;">&nbsp; ' . date('Y') . ' &nbsp;</span>';
        $pdf->SetXY(135, 103);
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->SetFont('times', '', 16);
        $html = '<span style="color:blue;">&nbsp; ' . $signature . ' &nbsp;</span>';
        $pdf->SetXY(90, 115);
        $pdf->writeHTML($html, true, false, true, false, '');

        // ---------------------------------------------------------
        //Close and output PDF document
        $factory->makeDir($certificate_folder);
        $pdf->Output($certificate_name, 'F');

        return $certificate_name;
    }

    public function sendEmail($result_winner) {
        $tmp_array = array();

        $email = new Email();
        $factory = new KazistFactory();

        $losserblogs = $this->getLosserBlogs($result_winner->contest_id, $result_winner->contest_season, $result_winner->id);

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Send To Winner xxxxxxxxxxxxxxxxxxxxx
        $tmp_array['user'] = $factory->getRecord('#__users_users', 'uu', array('id=:id'), array('id' => $result_winner->user_id));
        $tmp_array['contest'] = $this->getContestById($result_winner->contest_id);
        $tmp_array['blog'] = $this->getBlogById($result_winner->blog_id);
 
        $attachments = array($this->certificate_file);

        $email->sendDefinedLayoutEmail('cms.contests.contestwinner', $tmp_array['user']->email, $tmp_array, $attachments);

        //xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  Send To Lossers xxxxxxxxxxxxxxxxxxxxx

        if (!empty($losserblogs)) {
            foreach ($losserblogs as $key => $losserblog) {

                $tmp_array['user'] = $factory->getRecord('#__users_users', 'uu', array('id=:id'), array('id' => $losserblog->user_id));
                $tmp_array['contest'] = $this->getContestById($losserblog->contest_id);
                $tmp_array['blog'] = $this->getBlogById($losserblog->blog_id);

                $email->sendDefinedLayoutEmail('cms.contests.contestlosser', $tmp_array['user']->email, $tmp_array);
            }
        }
    }

    public function createDir($certificate_folder) {
        if (!is_dir($certificate_folder)) {
            mkdir($certificate_folder, 777, true);
        }
    }

    public function getContestWinners($contest_id, $contest_season) {
        $factory = new KazistFactory();


        $query = new Query();
        $query->select('cw.*, b.name AS blog_name, bc.name AS contest_name');
        $query->from('#__cms_contests_winners', 'cw');
        $query->leftJoin('cw', '#__cms_blogs', 'b', 'b.id = cw.blog_id');
        $query->leftJoin('cw', '#__cms_blogs_contest', 'bc', 'bc.id = cw.contest_id');
        $query->where('cw.contest_id=:contest_id');
        $query->andWhere('cw.contest_season=:contest_season');
        $query->setParameter('contest_id', $contest_id);
        $query->setParameter('contest_season', $contest_season);

        $query->setFirstResult(0);
        $query->setMaxResults(1);

        $record = $query->loadObjectList();

        return $record;
    }

    public function getLosserBlogs($contest_id, $season_no, $winner_id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('ccr.*');
        $query->from('#__cms_contests_results', 'ccr');
        $query->where('ccr.contest_id=:contest_id');
        $query->andWhere('ccr.contest_season=:contest_season');
        $query->andWhere('ccr.id<>:id');
        $query->setParameter('id', $winner_id);
        $query->setParameter('contest_id', $contest_id);
        $query->setParameter('contest_season', $season_no);
        $query->orderBy('total_points ', 'DESC');
        $query->orderBy('total_values ', 'DESC');

        $records = $query->loadObjectList();

        return $records;
    }

    public function getTopContestResult($contest_id, $season_no) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('ccr.*');
        $query->from('#__cms_contests_results', 'ccr');
        $query->where('ccr.contest_id=:contest_id');
        $query->andWhere('ccr.contest_season=:contest_season');
        $query->setParameter('contest_id', $contest_id);
        $query->setParameter('contest_season', $season_no);
        $query->orderBy('ccr.total_points ', 'DESC');
        $query->orderBy('ccr.total_values ', 'DESC');

        $record = $query->loadObject();

        return $record;
    }

    public function getContestWinner($contest_id, $season_no) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('ccw.*');
        $query->from('#__cms_contests_winners', 'ccw');
        $query->where('ccw.contest_id=:contest_id');
        $query->andWhere('ccw.contest_season=:contest_season');
        $query->setParameter('contest_id', $contest_id);
        $query->setParameter('contest_season', $season_no);

        $record = $query->loadObject();

        return $record;
    }

    public function getContests() {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('cc.*');
        $query->from('#__cms_contests', 'cc');
        $query->where('cc.start_date<now()');
        $query->andWhere('(cc.closed=0 OR cc.closed IS NULL)');

        $records = $query->loadObjectList();

        return $records;
    }

    public function getContestById($id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('*');
        $query->from('#__cms_contests', 'cc');
        if ($id) {
            $query->where('cc.id=:id');
            $query->setParameter('id', $id);
        } else {
            $query->where('1=-1');
        }

        $record = $query->loadObject();

        return $record;
    }

    public function getBlogById($id) {

        $factory = new KazistFactory();


        $query = new Query();
        $query->select('*');
        $query->from('#__cms_blogs', 'cb');
        if ($id) {
            $query->where('cb.id=:id');
            $query->setParameter('id', $id);
        } else {
            $query->where('1=-1');
        }

        $record = $query->loadObject();

        return $record;
    }

}
