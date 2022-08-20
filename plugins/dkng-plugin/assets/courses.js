jQuery(document).ready(function ($) {

    console.log('courses!!');

    /**
     * Function completing course for single course page
     *
     */
    function complete_course_function() {

        $(".complete_task_button").on("click", function (e) {
            e.preventDefault();

            var info = {
                course_id: $(this).attr('data-course-id'),
                action: 'complete_course'
            };
            $.post({
                url: get.ajaxurl,
                data: info,
                success: function ( data ) {
                    // console.log( data );
                    console.log('success');
                    $(".complete_task_button").removeClass("complete_task_button").text('Already completed.');
                },
                error: function ( data ) {
                    console.log('error');
                },
            });

        });

    }

    complete_course_function();

})