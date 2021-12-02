<?php
ini_set("log_errors", 1);
ini_set("error_log", __DIR__."/php-error.log");

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
if($_SERVER['HTTP_HOST']=="localhost" || $_SERVER['HTTP_HOST']=="127.0.1.1"|| $_SERVER['HTTP_HOST']=="blue.palace")
{
// ** MySQL settings - You can get this info from your web host ** //
	/** The name of the database for WordPress */
	define('DB_NAME', 'pankj_bluepalace');

	/** MySQL database username */
	define('DB_USER', 'root');

	/** MySQL database password */
	define('DB_PASSWORD', 'mysql');
}else{
	// ** MySQL settings - You can get this info from your web host ** //
	/** The name of the database for WordPress */
	define('DB_NAME', 'dactechn_bluepalace');

	/** MySQL database username */
	define('DB_USER', 'dactechn_bluepal');

	/** MySQL database password */
	define('DB_PASSWORD', 'NklNe6q9gXORNEMK');
	//define('DB_PASSWORD', 'W)56aPlvd4m6');
}
/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'k%@t}PyHStI*ly^d}BK2Y&-=IO.?asXbL5j#x}J^ 9e$y 0^.3:x.PzV:w1>j:$M');
define('SECURE_AUTH_KEY',  'U?73Hf)+*?i}`#qnK_G>rsjv:A::zMM[(cN ub9}WgPKLPJF0>q*NCAd7&S!==ip');
define('LOGGED_IN_KEY',    'M)aR9ocNK.22L1!7km12C m_hQ/i6<Q*/RG+l(Sg9~T>@ApLpbdFcuLxtXH.f<&V');
define('NONCE_KEY',        'KP_4^S{?B2t!#SF_M/bqp<[~1/AkmGk9)@!urgj^ycEdcNDSqb#D,b4>QFE=iACc');
define('AUTH_SALT',        'W$~/GC1`:ZN^~*5BmorpUWGxv4@5?jzL$F3W4.nQZ<gT</s(=J8ZmIbs4tLAy&{g');
define('SECURE_AUTH_SALT', 'FAIyW^o8S(xKc|o=e^(:/wEe:vrtJ{6W5w)b4-F+3B(UtRo#<2:z6{15}P1`}H=1');
define('LOGGED_IN_SALT',   '|0XZXq,U4|ztQm0_6X#`&uh(zr[,4S(d}rb&Cr}p2$/,%R(S8B{N07)K!j6oOCDA');
define('NONCE_SALT',       '-DUF2I#V`#]gKnml&IhdA*x*`bDH8@qF: Qa;{TLORNnVQIa&8`+Cw>;/<cmxX2-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'rs_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('DISABLE_WP_CRON', true);
