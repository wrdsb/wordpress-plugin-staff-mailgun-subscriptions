<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

require_once('Mailgun_Subscriptions/Cleanup.php');

function mailgun_clear_cron() {
	wp_clear_scheduled_hook(Mailgun_Subscriptions\Cleanup::WP_CRON_HOOK);
}

function mailgun_clear_posts() {
	update_option( 'mailgun_confirmation_expiration', 0 );
	Mailgun_Subscriptions\Cleanup::run();
}

function mailgun_clear_options() {
	foreach ( array(
		'mailgun_api_key',
		'mailgun_api_public_key',
		'mailgun_confirmation_page',
		'mailgun_confirmation_expiration',
		'mailgun_confirmation_email_template',
		'mailgun_welcome_email_template',
		'mailgun_lists',
	) as $option ) {
		delete_option( $option );
	}
}

mailgun_clear_cron();
mailgun_clear_posts();
mailgun_clear_options();