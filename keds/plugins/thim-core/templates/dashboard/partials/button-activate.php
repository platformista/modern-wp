<?php
$url_args = array(
	'page' => 'thim-license',
);

if ( ! empty( $args['return'] ) ) {
	$url_args['thim_redirect'] = urlencode( $args['return'] );
}

$url = add_query_arg( $url_args, admin_url( 'admin.php' ) );
?>
<a class="button button-primary tc-button" href="<?php echo esc_url( $url ); ?>">
	<?php esc_html_e( 'Activate theme', 'thim-core' ); ?>
</a>
