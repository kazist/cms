/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function () {
    contest.init();
});

contest = function () {
    return {
        init: function () {


            contest.addEvents(jQuery('body'));

        }, addEvents: function (html) {

            html.find(".contest-blogs-navigation a").on('click', function (event) {
                contest.loadContests(jQuery(this));
            });

            return html;
        }, loadContests: function (this_element) {

            var offset = this_element.attr('offset');
            var contest_id = this_element.attr('contest_id');
            var data_object = {offset: offset, contest_id: contest_id};

            console.log(data_object);

            var form = kazist.callAjaxByRoute('cms.contests.ajaxloadcontestblogs', data_object, true);

            jQuery('.contest-blogs-list').html(form);

            contest.addEvents(jQuery('.contest-blogs-list'));
        }

    };
}();