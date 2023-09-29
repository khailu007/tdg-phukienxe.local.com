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
define( 'DB_NAME', 'khachhang_wp_tdg-phukienxe' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'd@t@base' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3316' );

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
define( 'AUTH_KEY',         'P)G)`b~E;]FHuRB~6&_9S~Epjpcq7<`~(lc+pM+)D(}eElDGR?wQ2=M@}3Y9z -N' );
define( 'SECURE_AUTH_KEY',  '8|pY1_<Z/~gN;`zg.9$D,J_hdfGvgW($FdzL3ofYr.HO=Ni9g)=N?Dkeg,):,gQF' );
define( 'LOGGED_IN_KEY',    'Mq_wAl{G$O*)YmDBNl_}n+l^?%gy;S,)0-C#_c)@^:.:nT+PfvR?D:,G_s7OH{*q' );
define( 'NONCE_KEY',        'KKD@Z7cG])Cf<`01gN  XWlG+u2;1y6x@p$w8V`tDvfSB[wvCa dWj7__!Q[8y>;' );
define( 'AUTH_SALT',        'n)9gh61gjU-><?+?dN)#:d2fXzV(~]KjGiO/rOfhi=DMfb$g=%&pL@Mo1Q[<3Z{2' );
define( 'SECURE_AUTH_SALT', 't319L;zoUVdXT,)Z[9sF[DE*Kf+pud^_MqDr^_qkaEl<u;M* 0){=8jRVpQ)S_qI' );
define( 'LOGGED_IN_SALT',   '82#xUh8%NItCDvh{G|J$]K4_6s}dpp;v91?(PMNdcE6hP@U<0-|_7ENUZK}q1>X~' );
define( 'NONCE_SALT',       'knJ21c&2uHRuS2PGr/r@:@s5,c[=~8bLfNR={JiVV)Fv;2r3Ktu`J,IRwTc7IP~b' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
