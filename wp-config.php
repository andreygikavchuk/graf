<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home/u293813465/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'graf');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'root');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '.TNpy D(]ZX|/c7<hAr,J6rRRA&sq$Kg,n+&?gppaZ{;T4QHJ5l.&<SE <dx/qXh');
define('SECURE_AUTH_KEY',  '`g8|`!Nk:l!x)bLl6jmh+-`:va[C$$Y)D=A^S<|(Z9@5(MWOPsBM8Y?0#@UlZPiY');
define('LOGGED_IN_KEY',    ']Yw:!)d.#NFo#_r<n8Oy8{=5AIFDk{?5LLhot97m<%es44+K>:a>8Pu,VP&*x].>');
define('NONCE_KEY',        'q j9O !2++pIi.Am)5YA{Q]<}9w1OeOf>FkS}c]Bu7gY%5;b9o_*UF#lKEC&vHS]');
define('AUTH_SALT',        'FR3cX<vtE[NOvk<~FLWt8$@M(q(:?Q8Car.Gg(PI=UXd{iN&/z]`&4[hGb[W!n-F');
define('SECURE_AUTH_SALT', 'i%0Dv)?QkTP!^,lpnA SL.V+P>jwQ%|IX_oy@y.(n$P;[tc.u?4ma^k5[gGZB`h5');
define('LOGGED_IN_SALT',   'ZXG2xR !t3yjaNp;[f0*-.K]ube|={qMb8qzX>4*J^K?-R!mvy~dCkY &pnVMN6e');
define('NONCE_SALT',       'CkK4(VSraF{7XM+GLEXP*LG@T:r,B@?|2$Z`;JW_mMLO9{#|DK+Uk2jgMaW%a]wK');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
