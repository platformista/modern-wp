<?php
$default      = array(
    'consumer_key'        => 'fCuXeJBzIhikOjNFmh7FC7Cpz',
    'consumer_secret'     => 'tLefeE8nyARq1aIAJF7GSIhAoAxQiAMU9aX0RE79F6IVAcfA7J',
    'access_token'        => '3546925700-hzs7KwBYCqsZxP6sYRtjIS4V1TIMgh0zY0Hlhb5',
    'access_token_secret' => 'TmI0MW7QH7KTfdePVX1Swsie7i2K1RziunVc46y0wOALn'
);
$thim_twitter = get_option( 'thim_twitter', $default );

$twitter_id          = $instance['username'];
$number              = $instance['display'];
$consumer_key        = $thim_twitter['consumer_key'];
$consumer_secret     = $thim_twitter['consumer_secret'];
$access_token        = $thim_twitter['access_token'];
$access_token_secret = $thim_twitter['access_token_secret'];

if ( $twitter_id && $number && $consumer_key && $consumer_secret && $access_token && $access_token_secret ) {
    $transName = 'list_tweets_' . $twitter_id;
    $cacheTime = 10;

    $twitterData = get_transient( $transName );
    @$twitter = json_decode( get_transient( $transName ), true );

    if ( false === $twitterData || isset( $twitter['errors'] ) ) {
        $twitter_token = 'twitter_token_' . $twitter_id;
        $token         = !empty( $thim_twitter[$twitter_token] ) ? $thim_twitter[$twitter_token] : false;
        if ( !$token ) {
            // preparing credentials
            $credentials = $consumer_key . ':' . $consumer_secret;
            $toSend      = base64_encode( $credentials );
            // http post arguments
            $args_twitter = array(
                'method'      => 'POST',
                'httpversion' => '1.1',
                'blocking'    => true,
                'headers'     => array(
                    'Authorization' => 'Basic ' . $toSend,
                    'Content-Type'  => 'application/x-www-form-urlencoded;charset=UTF-8'
                ),
                'body'        => array( 'grant_type' => 'client_credentials' )
            );

            add_filter( 'https_ssl_verify', '__return_false' );
            $response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args_twitter );

            $keys = json_decode( wp_remote_retrieve_body( $response ) );

            if ( $keys ) {
                // saving token to wp_options table
                $token                        = $keys->access_token;
                $thim_twitter[$twitter_token] = $token;
                update_option( 'thim_twitter', $thim_twitter );
            }
        }
        // we have bearer token wether we obtained it from API or from options
        $args_twitter = array(
            'httpversion' => '1.1',
            'blocking'    => true,
            'headers'     => array(
                'Authorization' => "Bearer $token"
            )
        );

        add_filter( 'https_ssl_verify', '__return_false' );
        $api_url  = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $twitter_id . '&count=' . $number;
        $response = wp_remote_get( $api_url, $args_twitter );
        set_transient( $transName, wp_remote_retrieve_body( $response ), 60 * $cacheTime );
    }
}
@$twitter = json_decode( get_transient( $transName ), true );

?>
<div class="thim-twitter">
    <div class="twitter-inner">

        <?php
        if ( $instance['title'] <> '' ) {
            echo ent2ncr( $args['before_title'] . $instance['title'] . ' <i class="fa fa-x-twitter"></i>' . $args['after_title'] );
        }

        if ( $twitter && is_array( $twitter ) ) : ?>

            <div class="thim-tweets">
                <div class="twitter-item-wrapper">
                    <div class="row">
                        <?php foreach ( $twitter as $tweet ):
                            $twitterTime = strtotime( $tweet['created_at'] );

                            $twitterTimeStr = date( 'd M Y', $twitterTime );
                            $username       = $tweet['user']['screen_name'];
                            $displayName    = $tweet['user']['name'];
                            $latestTweet    = $tweet['text'];
                            $latestTweet    = preg_replace( '/https:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '<a href="https://$1" target="_blank">https://$1</a>', $latestTweet );
                            $latestTweet    = preg_replace( '/@([a-z0-9_]+)/i', '<a href="https://twitter.com/$1" target="_blank">@$1</a>', $latestTweet );
                            $latestTweet    = preg_replace( '/#([a-z0-9_]+)/i', '<a href="https://twitter.com/hashtag/$1" target="_blank">#$1</a>', $latestTweet );
                            ?>
                            <div class="tweet-item col-sm-12">
                                <div class="content">
                                    <?php echo ent2ncr( $latestTweet ); ?>
                                </div>
                                <div class="tweet-footer">
                                    <div class="top">
                                        <a href="https://twitter.com/<?php echo esc_attr( $username ); ?>/status/<?php echo esc_attr( $tweet['id_str'] ); ?>" target="_blank"><i class="fa fa-x-twitter"></i></a>
                                    </div>
                                    <div class="bottom">
                                        <strong><?php echo esc_html( $displayName ); ?></strong>
                                        <span class="username"><?php echo esc_html__( '@', 'eduma' ) . $username ; ?></span>
                                        <span class="ago"><?php echo esc_html( thim_time_ago( $twitterTime ) ); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>