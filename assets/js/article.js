/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function () {
    article_form.init();
});

article_form = function () {
    return {
        init: function () {

            article_form.addEvents(jQuery('body'));

        }, addEvents: function (html) {

            html.find('form').submit(function () {
                return article_form.formValidation(jQuery(this));
            });

            return html;

        }, formValidation: function (this_element) {

            var title = 'Validation Error';
            var message = '';
            var is_valid = true;
            var error_count = 1;

            var article_title = this_element.find('.article-detail-form .title-group #title');
            var short_description = this_element.find('.article-detail-form .short_description-group #short_description');
            var category_id = this_element.find('.article-detail-form .category_id-group #category_id');
            var content = tinyMCE.get('article').getContent();

            var article_title_val = article_title.val();
            var short_description_val = short_description.val();
            var category_id_val = category_id.val();

            if (article_title_val === '') {
                article_title.closest('.form-group').addClass('has-error');
                is_valid = false;
                message += '<br>' + error_count + ' Title is a required Fields and can not be empty';
                error_count++;
            }

            if (category_id_val === '') {
                category_id.closest('.form-group').addClass('has-error');
                is_valid = false;
                message += '<br>' + error_count + 'Category is a required Fields and can not be empty';
                error_count++;
            }

            if (short_description_val.trim() === '') {
                console.log(short_description.closest('.form-group'));
                short_description.closest('.form-group').addClass('has-error');
                is_valid = false;
                message += '<br>' + error_count + 'Short Description is a required Fields and can not be empty';
                error_count++;
            }


            if (content === '') {
                this_element.find('.article-group').addClass('has-error');
                is_valid = false;
                message += '<br>' + error_count + 'Article is a required Fields and can not be empty';
                error_count++;
            }

            if (!is_valid) {
                kazist.showDialog(title, message, 'error', 450);
                return false;
            }

            this_element('.article-survey-form').remove();
        }

    };
}();