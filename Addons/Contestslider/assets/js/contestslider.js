/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function () {
    jQuery('#slideShow').ayaSlider({
        easeIn: 'easeOutBack',
        easeOut: 'linear',
        timer: jQuery('#header'),
        previous: jQuery('.prev'),
        next: jQuery('.next'),
        list: jQuery('.slideControl'),
        delay: 4000
    });
});
