<?php
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'campanie_delaco' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'TSWn|]2dA[>3ydXS-W~ORawX?}:2qonFkMGzE6rWw$<>77{aVr3G ErhI`PfF0,n' );
define( 'SECURE_AUTH_KEY',  '*v|7MTk3DSX_f;=C<q400rnqHWLPdu)LoY8*irQk:0:xI% gw(&%2b-PgI2&[)NS' );
define( 'LOGGED_IN_KEY',    'pbNmkH1LqSS#iIXf:nvhN,UX^`&G7&G!p`{^B:q=)Knv{LJ?Wa25IvTZef8Tge^2' );
define( 'NONCE_KEY',        '$2[oix^atW.`Zm6Wgd1EX0/V9?u6zcW NDJgNpfWN_OsG,|H.1|6FsyukrylK=[N' );
define( 'AUTH_SALT',        'x(qe`xrUj)hP^ |5hTWBF_^-wq QT%%p 3F>;M:3b89gj/]TD*.]U|loG`AvGg%l' );
define( 'SECURE_AUTH_SALT', 'Z|)FBc]I[n1S+qsRf46b,[!CA7*1*HCp8xrkiSe<YQ@g*k:]^9F!22?.|1VS_pvb' );
define( 'LOGGED_IN_SALT',   'd$|O=Na*zfF~SUrU66_C^/8:Ck.eF/};N+gv]a(1tq}(yH._V(JUR$ B1`/%8?3B' );
define( 'NONCE_SALT',       'Q)cxU)|C}|feEj?1ad.H)ha=P,+VcW3m?cd~P%LQVh}H]T= !!WF.2f|Irgmx[^<' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
