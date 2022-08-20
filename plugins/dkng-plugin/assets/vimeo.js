var autoplay = localStorage.getItem( 'video-autoplay' );
var player = new Vimeo.Player('player');

var video_seconds = $("#player").attr("data-video-current-seconds");
if ( autoplay != 1 ) {
    player.setCurrentTime( video_seconds );
}
if ( autoplay == 1 ) {
    player.play();
    video_seconds = video_seconds - 2;
    player.setCurrentTime( video_seconds );
    localStorage.setItem( 'video-autoplay', '0' );
}

player.on( 'progress', (data) => {
    console.log('data.percent ', data.percent );
    if ( data.percent == 1 ){
        //Manually set the data to 100
        // data.percent = 1;
        //Remove the listeners
        player.off('pause');
        // player.off('progress');
    }
    else {
        updateProgress( data, 'seeked' );
    }

});

player.on( 'pause', function() {

    console.log('Paused.');

    var array = [];
    var active_class = $(".video-player li.lesson.active");
    var parent_index = ( active_class.parent('ul').hasClass('parent') ) ? active_class.parent('ul.parent').find('li.lesson_parent').attr('data-index') : 0;
    var lesson_video =  active_class.attr('data-video-id');
    var lesson_link  =  active_class.find('a.video-link').attr('data-link');
    var lesson_name  =  active_class.find('span.video-name').text();
    var active_index =  active_class.attr('data-index');
    var course_id    = parseInt($("#player").attr("data-course-id"));

    var current_time = player.getCurrentTime().then( function(current_time) {
        array.current_time = current_time;

        var duration = player.getDuration().then( function(duration) {
            array.duration = duration;
            var percentage = ( current_time * 100 ) / duration;
            array.percentage = percentage;

            var data = {
                course_id:     course_id,
                current_time:  current_time,
                duration:      duration,
                percentage:    percentage,
                lesson_video:  lesson_video,
                lesson_link:   lesson_link,
                lesson_name:   lesson_name,
                parent_index:  parseInt(parent_index),
                active_index:  parseInt(active_index),
                action:        'progress_lesson'
            };

            console.log( 'data', data);
            $.post({
                url: get.ajaxurl,
                data: data,
                success: function (data) {
                    console.log('red',data);
                    // alert('success pause');
                    var percent = data.percentage;
                    $(".video-player li.lesson.active").find(".progress .progress-bar").css( 'width', percent+'%' );
                    $(".video-player li.lesson.active").find(".progress .progress-bar").attr( 'aria-valuenow', percent );
                    $(".video-player li.lesson.active").attr( 'data-seconds', percent );

                    if ( parseInt( percent ) == 100 ) {
                        $(".video-player li.lesson.active").find("span.number").html( '<i class="fa fa-check"></i>' );
                    }

                },
                error: function (data) {
                    console.log('error');
                    console.log(data);
                },
            });
        }).catch(function(error) {
            console.log('error1');
        });
    }).catch(function(error) {
        console.log('error2');
    });

    console.log('end pause');
});

player.on( 'play', function() {
    console.log('played the player 2.0 video!');
});

player.on( 'ended', function() {
    console.log('Finished.');

    var array        = [];
    var course_id    = $("#player").attr("data-course-id");
    var active_class = $(".video-player li.lesson.active");
    var lesson_video =  active_class.attr('data-video-id');
    var lesson_link  =  active_class.find('a.video-link').attr('data-link');
    var parent_index = ( active_class.parent('ul').hasClass('parent') ) ? active_class.parent('ul.parent').find('li.lesson_parent').attr('data-index') : 0;
    var active_index =  active_class.attr('data-index');

    var current_time = player.getCurrentTime().then( function( current_time ) {
        array.current_time  = current_time;

        var duration = player.getDuration().then( function( duration ) {
            array.duration   = duration;
            var percentage   = ( current_time * 100 ) / duration;
            array.percentage = percentage;

            var data = {
                course_id:     course_id,
                current_time:  current_time,
                duration:      duration,
                percentage:    percentage,
                lesson_video:  lesson_video,
                lesson_link:   lesson_link,
                parent_index:  parseInt(parent_index),
                active_index:  parseInt(active_index),
                action:        'progress_course'
            };

            console.log('data', data);
            $.post({
                url: get.ajaxurl,
                data: data,
                success: function ( data ) {
                    // alert('finished');
                    console.log(data);
                    $(".progress_bar .percent_count, .percent_count .count").text(data.data.percentage);
                    $(".circle_progress_bar").attr('data-value', data.data.percentage );
                    $(".progress_bar .int_count").text(data.data.total);
                    $(".progress_bar .all_count").text(data.data.all_count);
                    $(".progress_bar #percent").val(data.data.percentage);

                    $(".video-player li.lesson.active").find(".progress .progress-bar").css( 'width', '100%' );
                    $(".video-player li.lesson.active").find(".progress .progress-bar").attr( 'aria-valuenow', '100' );
                    $(".video-player li.lesson.active").find("span.number").html( '<i class="fa fa-check"></i>' );
                    $(".video-player li.lesson.active").attr("data-seconds", 100);
                    progress_bar();
                    if ( parseInt( data.data.percentage ) == 100 ) {
                        $(".complete_task_button").removeClass('disabled');
                    }
                    play_next_video();

                },
                error: function (data) {
                    console.log('error');
                    console.log(data);
                    play_next_video();
                },
            });
        }).catch(function(error) {
            console.log('error1', error.message);
            // an error occurred
        });
    }).catch(function(error) {
        console.log('error2', error.message);
        // an error occurred
    });

});

/**
 * Play next video
 *
 */
function play_next_video() {

    // alert('next video');
    if ( $(".lesson.active").parent('ul.parent').length ) {
        if( $(".lesson.active").next('.lesson').length > 0) {
            $(".lesson.active").removeClass('active').next('.lesson').addClass('active');
        } else {
            if ( $(".lesson.active").parent('ul.parent').length ) {
                if( $(".lesson.active").next('.lesson').length > 0) {
                    $(".lesson.active").removeClass('active').next('.lesson').addClass('active');
                } else {
                    var activeLesson = $(".lesson.active");
                    activeLesson.removeClass('active');

                    if(activeLesson.parent("ul.parent").next('.lesson').length) {
                        activeLesson.parent("ul.parent").next('.lesson').addClass('active');
                    } else if(activeLesson.parent("ul.parent").next('.parent')) {
                        activeLesson.parent("ul.parent").next('.parent').find('.lesson').first().addClass('active');
                    }

                }
            }
        }
    }
    else {
        var activL = $(".lesson.active");

        activL.removeClass('active');

        if(activL.next('.lesson').length) {
            activL.next('.lesson').addClass('active');
        } else if(activL.next('.parent').length) {
            activL.next('.parent').find('.lesson').first().addClass('active');
        }
    }

    var vimeo_id = $(".lesson.active").find('a.video-link').attr('data-vimeo-id');

    if(vimeo_id) {
        localStorage.setItem( 'video-autoplay', '1' );
        $(".lesson.active").trigger('click');
        // location.reload();

        $("#player").attr('data-vimeo-url', "//player.vimeo.com/video/"+ vimeo_id +"?api=1&player_id=vimeovideo");
        $("#player iframe").attr('src', "//player.vimeo.com/video/"+ vimeo_id +"?api=1&player_id=vimeovideo");
    }
}

/**
 * Function setting progress bar for whole courses
 *
 */
function progress_bar() {
    $(".progress.circle").each(function () {

        var value = $(this).attr('data-value');
        var left  = $(this).find('.progress-left .progress-bar');
        var right = $(this).find('.progress-right .progress-bar');

        if ( value > 0 ) {
            if ( value <= 50 ) {
                right.css('transform', 'rotate(' + percentage_to_degrees( value ) + 'deg)' )
            } else {
                right.css( 'transform', 'rotate(180deg)' )
                left.css( 'transform', 'rotate(' + percentage_to_degrees( value - 50 ) + 'deg)')
            }
        }

    })
}

/**
 * Set percent to degree in element
 *
 * @param percentage
 * @returns {number}
 */
function percentage_to_degrees( percentage ) {
    return percentage / 100 * 360
}
