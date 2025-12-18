<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kosugiai_cms' );

/** Database username */
define( 'DB_USER', 'kosugiai_cms' );

/** Database password */
define( 'DB_PASSWORD', 'kosugiai_cms' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

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
define( 'AUTH_KEY',         '|Lc>>3[wfxm+0!114ZT{/f[cBv#^vz|<j[!pvTmf@lb6QMzp0gubqtbSX[ g]&dl' );
define( 'SECURE_AUTH_KEY',  'C-JEL>zQCHPq<m+8`WG7+!~|pa?Ev{$=Mu=tv}*xxJ,l*j<a%M<*E}E)7t[yGyh<');
define( 'LOGGED_IN_KEY',    'f-k%Xo+dLM>D+^R!jU13<zn5~5]wEyTpqZI^A,-3^KEQ,BWT}7K7!Vb9c8s=>&(|');
define( 'NONCE_KEY',        'QrVN[F!1_G37YSCA}Mu|Xxr+sSnutb~RWv0G+YMUzi2lFlN;PLti`{R]p:M=,$t#');
define( 'AUTH_SALT',        'zv(ejtOk%@<tSJqON+v<m*wKS(;Q@C[H+$miE:Q5%+h@)D@ 7j/nw-$;D`m>m~yR');
define( 'SECURE_AUTH_SALT', 'D4+,*r-L0g|8z/Y3|M||n[@!jy1aEAh+6BX}L{+aQk=eN(_KX;}-7$W}A4b2L#^@');
define( 'LOGGED_IN_SALT',   '+uvB#5L;-{&%8M:)I:OSHr=4ZClE;|rAbj|9#N_&h/h}y-k,q9)-+ &vb>b|Y}O`');
define( 'NONCE_SALT',       'yI+*(VNmr5?2]$+oWH^1qv1Sc]hCl-~ig4Ly%@)M:<plH{;3kIy=jhmIz?$(v.*d');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Absolute path to the Document Root directory. */
if ( ! defined('DOCUMENT ROOT') ) {
    define('DOCUMENT ROOT', __DIR__ . '/..');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
