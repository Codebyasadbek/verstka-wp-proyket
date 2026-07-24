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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '`wQEE-e4]5-Z<bD%lhT$I)24Zwm>h%%><UL/lV,p%*0z;9Qab;t-dXKYnba=ehEf' );
define( 'SECURE_AUTH_KEY',   'hwi!$.A,REjk08S30_ER-Ak5H?ez`C,ncYVy J{_wI;,~Wp9N5`KB l!]k}#t)ZH' );
define( 'LOGGED_IN_KEY',     'MjmFYlI,mP#!$:Ia:$y(N{}|fZMUINgR%3KdBo4.a[%xd-U!EH*_Y~L:h1s=NJcY' );
define( 'NONCE_KEY',         'O-f:tE[$&S$Rh;TvXNCCVp%Z4+vQb`)XdcSUaF*b#%+6{`PbBS?TIv3Jvpj?_$fg' );
define( 'AUTH_SALT',         'o]pHCZo>oFi6.I; D<l9Dye/#WVCT}J(fNWlipY&!{`+X!Kx3sGD?X&[;dvI;BU/' );
define( 'SECURE_AUTH_SALT',  'Ldw3~|H[m85pNi?M=d-C~fGEoda6vr^C-,J*_q1hIAGq7:L8S8-1;=P3ePP}LsG+' );
define( 'LOGGED_IN_SALT',    '`j3SUlm.X>e/DePCj-OP*B$BgdY2KUgZO9;X@lsa7){@aD137wD}Ns*EZf8gA&:A' );
define( 'NONCE_SALT',        'TlH<m}+Q;8rcxUFKj *&T6/EFbh<<|s^[NhC3nn>rR2- (Uiuqn~eS9SvW/};fsK' );
define( 'WP_CACHE_KEY_SALT', '$vm[4w0#9he02;ZSKqZs+WcHn8DuI/ruGjEH|I/=0b?DS!v&27!2+nJ]@}yuT,;a' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
