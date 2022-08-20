<?php

$client = new GuzzleHttp\Client();

$res = $client->request(
    'POST',
    'https://app.ayrshare.com/api/post',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            // Live API Key
            'Authorization' => 'Bearer PYMNKKY-MN44A4A-JB3SRA0-99N920R'
        ],
        'json' => [
            'post' => 'Post - https://finplaninfo.io/articles/company_name/your-holiday-wellness-plan-comes-down-to-avoiding-stress-and-taxes-2/',
//            'platforms' => ['twitter', 'facebook', 'instagram', 'linkedin', 'telegram'],
            'platforms' => ['facebook'],
            'mediaUrls' => ['https://images.ayrshare.com/imgs/GhostBusters.jpg'],
        ]
    ]
);

echo json_encode(json_decode($res->getBody()), JSON_PRETTY_PRINT);

//require_once("/YOUR_PATH_TO/facebook_php_sdk/facebook.php");

// initialize Facebook class using your own Facebook App credentials
// see: https://developers.facebook.com/docs/php/gettingstarted/#install
//$config = array();
//$config['app_id'] = '158692912059608';
//$config['app_secret'] = '831cbe2cab03f7dd73e317de4e2baf85';
//$config['fileUpload'] = false; // optional

//
//$appId = '1254811465026062';
//$appSecret = 'da2b34bcee7930156349a27dea0e0546';
//$pageId = '4424881694260235';
//$token = 'EAAR1PoZBiCg4BAJXxNKWnRZBjffO2WDKPVZAIEVMoErlTq1MWKO63ZA6ttXThyIMN93d7tHhiP9Pk4DmvBzNnccxIWzuywVUMwg7jiWUZBwZCVvEdvavSVvQneP86QdLIuTZCLIkt3MqogTGpOF0JqUkPZCY8Efu5lDBSSXHGQsCPSay9huOHCBj1fSqpwB5xdZA8DFOnO1JKFhCdT6ZBCUWyow6gMuf8sFGBoF5mtiJuYWWTM54tjICzL';

//$appId = '269414268447721';
//$appSecret = 'b8960743f05bac7315c5f8e2a590d357';
//$token = 'EAAD1BZBXEqZBkBAK5gLtLyAKQAKuM49q9ciuAq2TjRPgaDV81tz9StobZCgUQFaUizhKxSzXIKDZCEZCUDkIfIPAqKT96Nii2580ZC47CzIzLinta5KbDQsWP2H6ZAvomcU9HN7IQagWmwUIZBhIbsIBJUXg0zN9qQQyRZAPydVa21ah0MvhjT1Sw';
//
//// Include FB configuration file
////require_once 'fbConfig.php';
//$fb = new \Facebook\Facebook([
//    'app_id' => $appId,
//    'app_secret' => $appSecret,
//    'default_graph_version' => 'v2.5'
//]);
//if (isset($token)) {
//    if (isset($token)) {
//        $fb->setDefaultAccessToken($token);
//    } else {
//        // Put short-lived access token in session
//        $token = (string)$token;
//
//        // OAuth 2.0 client handler helps to manage access tokens
//        $oAuth2Client = $fb->getOAuth2Client();
//
//        // Exchanges a short-lived access token for a long-lived one
//        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($token);
//        $token = (string)$longLivedAccessToken;
//
//        // Set default access token to be used in script
//        $fb->setDefaultAccessToken($token);
//    }
//
//    //FB post content
//    $message = 'Test message from CodexWorld.com website';
//    $title = 'Post From Website';
//    $link = 'http://www.codexworld.com/';
//    $description = 'CodexWorld is a programming blog.';
//    $picture = 'http://www.codexworld.com/wp-content/uploads/2015/12/www-codexworld-com-programming-blog.png';
//
//    $attachment = array(
//        'message' => $message,
//        'name' => $title,
//        'link' => $link,
//        'description' => $description,
//        'picture' => $picture,
//    );
//
//    try {
//        // Post to Facebook
//        $fb->post('/me/feed', $attachment, $token);
//
//        // Display post submission status
//        echo 'The post was published successfully to the Facebook timeline.';
//    } catch (\FacebookResponseException $e) {
//        echo 'Graph returned an error: ' . $e->getMessage();
//        exit;
//    } catch (\FacebookSDKException $e) {
//        echo 'Facebook SDK returned an error: ' . $e->getMessage();
//        exit;
//    }
//} else {
//    // Get Facebook login URL
//    $fbLoginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
//
//    // Redirect to Facebook login page
//    echo '<a href="' . $fbLoginURL . '"><img src="fb-btn.png" /></a>';
//}


/*

$fb = new \Facebook\Facebook($config);
$page_id = 103151505507315;

// define your POST parameters (replace with your own values)
$params = array(
        "access_token" => "158692912059608|-gPW9hteIIpr8b4QwyGl5B51W28", // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
        "message" => "Here is a blog post about auto posting on Facebook using PHP #php #facebook",
        "link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
        "picture" => "http://i.imgur.com/lHkOsiH.png",
        "name" => "How to Auto Post on Facebook with PHP",
        "caption" => "www.pontikis.net",
        "description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation."
);

// post to Facebook
// see: https://developers.facebook.com/docs/reference/php/facebook-api/
try {
//        $ret = $fb->api('/100002153440101/feed', 'POST', $params);
        $ret = $fb->post("$page_id/feed", $params );
        echo 'Successfully posted to Facebook';
} catch(Exception $e) {
        echo $e->getMessage();
}

die;

/*
$appId = '1254811465026062';
$appSecret = 'da2b34bcee7930156349a27dea0e0546';
$pageId = '100002153440101';
$accessToken = '';
$fb = new \Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.5'
]);

$longLivedToken = $fb->getOAuth2Client()->getLongLivedAccessToken( "158692912059608|-gPW9hteIIpr8b4QwyGl5B51W28");

$fb->setDefaultAccessToken($longLivedToken);

$response = $fb->sendRequest('GET', '100002153440101', ['fields' => 'access_token'])
    ->getDecodedBody();

$foreverPageAccessToken = $response['access_token'];


$pageId = 'https://www.facebook.com/romanbolshyk';

$fb = new Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.5'
]);

$fb->setDefaultAccessToken($foreverPageAccessToken);
$fb->sendRequest('POST', "$pageId/feed", [
    'message' => 'I Like French Fries.',
    'link' => 'http://blog.damirmiladinov.com',
]);


die;
/*
?>

<form action="" class="sv-email-campaign scheduling_campaign_form" method="post">


    <td class="sv-email-campaign__date" data-th="<?php echo __( 'Sending date', 'dkng'); ?>">

        <div class="position-relative" data-prev-text="<?php echo $status_label;?> - ">
                <?php echo $sending_data;?>
                <button type="button" class="js-sending-date-edit sv-edit-field"></button>
            </div>

        <input type="hidden" name="date<?php echo $i;?>" class="js-sending-date" value="<?php echo $email_data["sending_time"];?>">
        <input type="hidden" name="type<?php echo $i;?>" value="create">
        <?php if ( !empty( $check ) || !empty( $check_draft ) ) { ?>
            <input type="hidden" name="edited_id<?php echo $i;?>" value="<?php echo $email_data['id'];?>">
        <?php } ?>
    </td>
    <td class="sv-email-campaign__schedule-button">
        <?php if( $email_data["status"] == 'sent') : ?>
            <button type="button" class="sv-button sv-button--blue-text js-campaign-button" disabled><?php echo __( "Scheduled", "dkng" );?></button>
        <?php elseif( $email_data["status"] == 'inprogress' ): ?>
            <button type="button" class="sv-button sv-button--blue-text js-campaign-button selected disabled" ><?php echo __( "Scheduled", "dkng" );?></button>
        <?php elseif( ( $email_data["status"] == 'draft' ) && ( !empty( $email_data["sending_time"] ) ) ): ?>
            <button type="button" class="sv-button sv-button--blue-text js-campaign-button selected disabled" ><?php echo __( "Scheduled", "dkng" );?></button>
        <?php elseif( $email_data["status"] == 'canceled' ): ?>
            <button type="button" class="sv-button sv-button--blue-text js-campaign-button " disabled><?php echo __( "Scheduled", "dkng" );?></button>
        <?php else: ?>
            <button type="button" class="sv-button sv-button--blue-text js-campaign-button js-datePicker"><?php echo __( "Schedule", "dkng" );?></button>
        <?php endif; ?>
    </td>

    <?php /*
    <input type="hidden" name="campaign_id" value="<?php echo $post_id;?>">

    <table class="sv-email-campaign__table js-campaign-table">

        <tbody class="js-equal-subject-body">
            <?php if ( !empty( $email_disclosure ) ) { ?>
                <div class="email_disclosure_content" style="display: none;">
                    <?php echo $email_disclosure;?>
                </div>
            <?php } ?>
            <?php
            $check       = false;
            $check_draft = false;

                $i = 0;
                    $i++;
                    $email_data = $campaigns_obj->get_scheduling_email_data( $post_id, $user->ID, $email['email_subject'] );

                    $subs = array(
                        '/\[custom_link\](.+)\[\/custom_link\]/Ui' =>
                            '<a style="background-color:#789;color:#fff;min-width:120px;text-decoration:none;font-weight:500;text-align:center;letter-spacing:.2px;display:inline-block;border-radius:17px;padding:6px 10px;" href="'.$email_data['custom_link'].'">$1</a>',
                    );

                    $str_text = preg_replace(array_keys( $subs ), array_values( $subs ), $email['email_body'] );
                    $str_text = str_replace( '@custom_paragraph', '', $str_text );

                    $use_custom_link = $email['use_custom_link'];
                    $str_text = mb_strimwidth( strip_tags( $str_text ), 0, 33, '...' );

                    $sending_data_format = '';

                    if ( empty( $email_data ) ) {
                        $sending_data = 'Not scheduled yet';
                    }
                    elseif ( $email_data['status'] == 'canceled' ) {
                        $sending_data = 'Canceled';
                    }
                    elseif ( $email_data['status'] == 'draft' ) {
                        $sending_data        = 'Draft';
                        $old_date            = strtotime( $email_data["sending_time"] );
                        $sending_data_format = date('m-d-Y h:ia', $old_date );
                        $sending_data       .= ' - ' .  $sending_data_format;
                        $check_draft = true;
                    }
                    else {
                        $sending_data        = ( $email_data["status"] == 'sent' ) ? 'Sent' : 'Active';
                        $old_date            = strtotime( $email_data["sending_time"] );
                        $sending_data_format = date('m-d-Y h:ia', $old_date );
                        $sending_data       .= ' - ' .  $sending_data_format;
                        $check = true;
                    }
                    $class = ( $email_data['status'] == 'canceled' ) ? 'canceled' : '';
                    $custom_link_class  = ( ( $email_data["status"] == 'sent' ) || ( $email_data["status"] == 'canceled' ) ) ? 'disabled' : '';
                    $custom_link_status = ( !empty( $use_custom_link ) ) ? '' : 'disabled';
                    $personal_token     = ( !empty( $email_data["custom_personal_token"] ) || empty( $email_data ) ) ? 'checked' : '';
                    $article_token      = ( !empty( $email_data["custom_article_token"] ) ) ? 'checked' : '';

                    $article_id         = !empty( $email['article'] ) ? $email['article'] : 0;
                    $article_title      = !empty( $article_id ) ? get_the_title( $article_id ) : '';

                    $article_link = '';

                    if ( !empty( $article_id ) ) {
                        $user_published_articles = get_user_meta($user->ID, 'published_articles', true);
                        $related                 = get_post_meta( $article_id, 'related_edited_article', true );
                        $related_user_id  = $related[$user->ID];

                        $articles_obj     = new \Dkng\Wp\ArticlesActions();
                        $get_related_post = !empty( $related_user_id ) ? $articles_obj->get_related_article_from_site2( $related_user_id ) : array();

                        $related_post_link  = ( !empty( $related_user_id ) && !empty( $get_related_post['link'] ) ) ? $get_related_post['link'] : "";
                        $related_post_title = ( !empty( $related_user_id ) && !empty( $get_related_post['title'] ) ) ? $get_related_post['title'] : "";

                        $link1         = ( !empty( $related_user_id ) ) ? $related_post_link : '';
                        $related_id    = ( !empty( $related_user_id ) && !empty( $related_post_title ) ) ? $related_user_id : 0;
                        $related_title = ( !empty( $related_user_id ) ) ? $related_post_title : '';

                        //  $link  = ( array_key_exists( $id , $user_published_articles ) ) ? get_the_permalink() : '';
                        $article_link  = ( is_array( $user_published_articles ) && array_key_exists( $article_id, $user_published_articles ) ) ? $link1 : '';
                        $checked       = ( is_array( $user_published_articles ) && !empty( $link ) && array_key_exists( $article_id, $user_published_articles ) ) ? 'checked' : '';
                    }
                    ?>
                        <tr data-scheduling-email-id="<?php echo $email_data['id'];?>" data-scheduling-email-status="<?php echo $email_data['status'];?>"
                            class="<?php echo $class;?>"  data-counter="<?php echo $i;?>" data-articleid="<?php echo $article_id;?>"
                            data-article_title="<?php echo $article_title;?>" data-article_link = "<?php echo $article_link;?>"
                            data-user="<?php echo $user->ID; ?>" data-shared-post="<?php echo $related_id; ?>"
                        >
                            <td class="sv-email-campaign__subject" data-th="<?php echo __( 'Email Subject', 'dkng'); ?>">
                                <div><?php echo $email['email_subject'];?></div>
                            </td>
                            <td class="sv-email-campaign__body" data-th="<?php echo __( 'Email Body', 'dkng'); ?>">
                                <div><button type="button" class="js-sending-body-edit sv-edit-field"></button><?php echo $str_text;?></div>
                            </td>


                            <td class="sv-email-campaign__cancel">
                                <?php if ( $email_data["status"] == 'sent' ) : ?>
                                    <button type="button" class="sv-close-button js-cancel-email" disabled></button>
                                <?php else: ?>
                                    <button type="button" class="sv-close-button js-cancel-email" data-id="<?php echo $email_data['id'];?>"></button>
                                <?php endif; ?>
                            </td>
                        </tr>
   ?>
<div class="sv-row">
    <div class="sv-email-campaign__submit">
        <div class="sv-hr"></div>
        <?php if ( empty( $check ) ) { ?>
        <button class="sv-button sv-button--green sv-button--small-padding js-draft-submit-campaign" type="button" >
            <?php echo __( "Save as Draft", "dkng" );?>
        </button>
        <?php } ?>
        <button class="sv-button sv-button--green sv-button--small-padding js-submit-campaign" type="submit" disabled>
            <?php
            if ( !empty( $check ) ) {
            echo __( "Save", "dkng" );
            }
            else {
            echo __( "Start", "dkng" );
            }
            ?>
        </button>
    </div>
</div>
</form>