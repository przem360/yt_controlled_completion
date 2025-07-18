<?php
/*
Plugin Name: YouTube Controlled Completion for LifterLMS
Description: Hides the "Mark Complete" button in LifterLMS lessons until the entire YouTube video has been watched. After viewing, it saves the information locally so the button doesn't disappear upon refresh.
Version: 1.2
Author: Przemysław Wolski
*/

add_shortcode('yt_complete_video', 'yt_complete_video_shortcode');

function yt_complete_video_shortcode($atts) {
    $controls = isset($atts['controls']) && $atts['controls'] === '1' ? '1' : '0';
    $atts = shortcode_atts([
        'video_id' => '',
        'width'    => '100%',
        'height'   => '480'
    ], $atts);

    if (empty($atts['video_id'])) {
        return '<p><strong>Error:</strong> Missing YouTube video ID.</p>';
    }

    $lesson_id = get_the_ID();
    $storage_key = 'yt_completed_lesson_' . $lesson_id;

    ob_start();
    ?>

    <style>
        #llms_mark_complete.hide-complete-btn {
            display: none !important;
        }
        #llms_mark_complete.show-complete-btn {
            display: block !important;
        }
    </style>

    <div class="yt-complete-wrapper">
        <iframe id="yt_complete_video_player"
            width="<?php echo esc_attr($atts['width']); ?>"
            height="<?php echo esc_attr($atts['height']); ?>"
            src="https://www.youtube.com/embed/<?php echo esc_attr($atts['video_id']); ?>?enablejsapi=1&controls=<?php echo $controls; ?>"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>
    </div>

    <script>
        const lessonKey = '<?php echo esc_js($storage_key); ?>';

        function showCompleteButton() {
            const btn = document.getElementById('llms_mark_complete');
            if (btn) {
                btn.classList.remove('hide-complete-btn');
                btn.classList.add('show-complete-btn');
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const btn = document.getElementById('llms_mark_complete');
            if (!btn) return;

            if (localStorage.getItem(lessonKey) === 'yes') {
                showCompleteButton();
            } else {
                btn.classList.add('hide-complete-btn');
            }
        });

        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('yt_complete_video_player', {
                events: {
                    'onStateChange': function(event) {
                        if (event.data === YT.PlayerState.ENDED) {
                            console.log("Video ended, unlocking completion button.");
                            localStorage.setItem(lessonKey, 'yes');
                            showCompleteButton();
                        }
                    }
                }
            });
        }
    </script>
    <script src="https://www.youtube.com/iframe_api"></script>

    <?php
    return ob_get_clean();
}

