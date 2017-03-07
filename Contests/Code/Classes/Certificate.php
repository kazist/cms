<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(JPATH_ROOT . '/vendor/tecnickcom/tcpdf/config/tcpdf_config.php');

require_once(JPATH_ROOT . '/vendor/tecnickcom/tcpdf/tcpdf.php');

class CertificatePDF extends TCPDF {

    //Page header
    public function Header() {

        $width = 210;
        $height = 150;

        //$orientation = ($height > $width) ? 'P' : 'L';
        //$this->addFormat("custom", $width, $height);
        //$this->reFormat("custom", $orientation);
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = JPATH_ROOT . '/assets/images/achievement_certificate.jpg';
        $this->Image($img_file, 0, 0, $width, $height, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }

}
