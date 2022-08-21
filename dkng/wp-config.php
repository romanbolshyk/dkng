<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'aooss_32418454_955' );

/** Database username */
define( 'DB_USER', '32418454_1' );

/** Database password */
define( 'DB_PASSWORD', 'pSfm[(3X84' );

/** Database hostname */
define( 'DB_HOST', 'sql308.byetcluster.com' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '3l0x6ladddjve3f7mdmygiminbyru6e2w1yuxmdvfce7kspegld3iq39ewssqayy' );
define( 'SECURE_AUTH_KEY',  'z4ohqtubik0xz7wwohbx9nro7xlee6ovrvetgrw2ssebizbi5s5je9z0bvylmwpr' );
define( 'LOGGED_IN_KEY',    'd5kivcuxf5572yrj3ffslpql858caef1ai7vonjx8letzjgp4bcva5ze9emzzrm5' );
define( 'NONCE_KEY',        '5nrmhzvwek1q4zxe5pfovztv40lowtc2qv0wgck3sd2thwr3yxkuaya0c3vruses' );
define( 'AUTH_SALT',        'gns2n53czv7rdervzzke3ypxdvbapsnxk73vgxgebozj7hohnbx0c1m3zi9d1jbc' );
define( 'SECURE_AUTH_SALT', 'xjk8vibvcux4q3igamtqngqdtqq6zg7ebthmkme2zquuqvsmkghccnwadx1psw3q' );
define( 'LOGGED_IN_SALT',   'dt8rugbjvcbvtd8jpyt7yac5cpou36dwlwdodb3cduvxzxl8mavzhk3qb4dtadyx' );
define( 'NONCE_SALT',       'ogx4siehdjaavd0x5oqgpwuptjljae0vuw7admfkxv0j3ukfhla6lmw4h0f31foz' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpxi_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
set_time_limit(1000);
@ini_set( 'upload_max_size' , '200M' );
@ini_set( 'post_max_size', '300M');
@ini_set( 'memory_limit', '500M' );

@ini_set( 'max_input_vars' , 20000 );
define('WP_MEMORY_LIMIT', '500M');
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
