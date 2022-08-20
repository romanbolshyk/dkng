var player;
var video_id_current = $("#player").attr("data-video-current-id");
var video_seconds    = $("#player").attr("data-video-current-seconds");
var course_id        = $("#player").attr("data-course-id");

var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

function onYouTubePlayerAPIReady() {
    player = new YT.Player('player', {
        height: '465',
        width: '750',
        host: 'https://www.youtube.com',
        playerVars: { 'autoplay': 0, 'origin': 'https://test.viewdemo.co', 'enablejsapi': 1, 'start': parseInt(video_seconds) },
        videoId: video_id_current,
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

setTimeout( 'onYouTubePlayerAPIReady', 500);

function loadPlaylistVideoIds( video_id, seconds ) {

    window.player.loadPlaylist({
        'playlist': video_id,
        'index': 1,
        'startSeconds': seconds,
        'suggestedQuality': 'small',
    });

}

// autoplay video
function onPlayerReady(event) {
    // event.target.playVideo();
    console.log('ready7');
}

// when video ends
function onPlayerStateChange( event ) {

    if ( event.data === 0 ) { //end of video event
        // alert('finish');
        var active_class = $(".video-player li.lesson.active");
        var parent_index =  ( active_class.parent('ul').hasClass('parent') ) ? active_class.parent('ul.parent').find('li.lesson_parent').attr('data-index') : 0;
        var active_index =  active_class.attr('data-index');
        var duration     =  player.getDuration();

        var info = {
            course_id:     course_id,
            parent_index:  parseInt(parent_index),
            active_index:  parseInt(active_index),
            action:       'progress_course'
        };

        $.post({
            url: get.ajaxurl,
            data: info,
            success: function (data) {
                // alert('success finish');
                console.log(data);
                $(".progress_bar .percent_count, .percent_count").text(data.data.percentage);
                $(".circle_progress_bar").attr('data-value', data.data.percentage );
                $(".progress_bar .int_count").text(data.data.total);
                $(".progress_bar .all_count").text(data.data.all_count);
                $(".progress_bar #percent").val(data.data.percentage);

                $(".video-player li.lesson.active").find(".progress .progress-bar").css( 'width', '100%' );
                $(".video-player li.lesson.active").find(".progress .progress-bar").attr( 'aria-valuenow', '100' );
                $(".video-player li.lesson.active").find("span.number").html( '<i class="fa fa-check"></i>' );
                progress_bar();

                if ( parseInt( data.data.percentage ) == 100 ) {
                    $(".complete_task_button").removeClass('disabled');
                }
            },
            error: function (data) {
                console.log('error');
                // console.log(data);
            },
        });
    }
    else if ( ( event.data === 2 ) ||  ( event.data == 2 ) ) { // pause event
        console.log('pause');
        var duration     = player.getDuration();
        var cur_time     = player.getCurrentTime();

        var active_class = $(".video-player li.lesson.active");
        var parent_index = ( active_class.parent('ul').hasClass('parent') ) ? active_class.parent('ul.parent').find('li.lesson_parent').attr('data-index') : 0;
        var active_index =  active_class.attr('data-index');
        var data = {
            course_id: course_id,
            duration: duration,
            cur_time: cur_time,
            parent_index:  parseInt(parent_index),
            active_index:  parseInt(active_index),
            action:       'progress_lesson'
        };


        $.post({
            url: get.ajaxurl,
            data: data,
            success: function (data) {
                alert('success pause');
                var percent = data.percentage;
                $(".video-player li.lesson.active").find(".progress .progress-bar").css( 'width', percent+'%' );
                $(".video-player li.lesson.active").find(".progress .progress-bar").attr( 'aria-valuenow', percent );
                if ( parseInt( percent ) == 100 ) {
                    $(".video-player li.lesson.active").find("span.number").html( '<i class="fa fa-check"></i>' );
                }
            },
            error: function (data) {
                console.log('error');
                // console.log(data);
            },
        });

    }

}

/**
 * Function setting progress bar
 * for course after ajax request
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
