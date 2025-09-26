<?php

/*
 * Build vector store in Redis example
 */

require __DIR__ . '/vendor/autoload.php';

use Predis\Client as PredisClient;
use Dhosting\VectorStore\DocumentVectorStore;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$redis = new PredisClient($_ENV['REDIS_URL']);

$store = new \Dhosting\VectorStore\DocumentVectorStore($redis, $_ENV['REDIS_INDEX_NAME']);

$store->add('help-001', "How do I install WordPress? Download the latest version of from wordpress.org, upload the files to your web server using FTP or your hosting control panel, create a MySQL database and user, and run the installation wizard by visiting your site. Follow the on-screen instructions to set up your site title, admin account, and password.");
$store->add('help-002', "How can I reset my WordPress password? On the login page, click 'Lost your password?', enter your username or email, and check your inbox for a reset link. If you can't access your email, you can reset your password via phpMyAdmin by editing the users table.");
$store->add('help-003', "How do I update plugins in WordPress? Go to Plugins > Installed Plugins in your dashboard. If updates are available, you'll see a notification. Click 'Update' next to the plugin, or select multiple plugins and use the bulk update option. Always backup your site before updating.");
$store->add('help-004', "How do I change my WordPress theme? Navigate to Appearance > Themes, browse or upload a new theme, and click 'Activate'. Preview themes before activating to ensure compatibility. Customize your theme using the Customizer under Appearance > Customize.");
$store->add('help-005', "How can I create a new post in WordPress? Go to Posts > Add New, enter your title and content, add images or media, assign categories and tags, and click 'Publish'. You can also schedule posts for future publication or save drafts.");
$store->add('help-006', "How do I add images to a WordPress post? In the post editor, click the 'Add Media' button, upload images from your computer, or select from the media library. You can add alt text, captions, and adjust alignment before inserting images into your post.");
$store->add('help-007', "How do I install a WordPress plugin? Go to Plugins > Add New, search for the desired plugin, and click 'Install Now'. After installation, click 'Activate'. For premium plugins, upload the .zip file using the 'Upload Plugin' button.");
$store->add('help-008', "How do I manage comments in WordPress? Go to Comments in the dashboard to view, approve, reply, edit, or delete comments. You can enable or disable comments for posts and pages in the Discussion settings. Use plugins to filter spam.");
$store->add('help-009', "How do I create a custom menu in WordPress? Navigate to Appearance > Menus, create a new menu, add pages, posts, categories, or custom links, and assign the menu to a location such as header or footer. Drag and drop items to reorder or create sub-menus.");
$store->add('help-010', "How do I backup my WordPress site? Use a backup plugin like UpdraftPlus or BackWPup to schedule automatic backups of your database and files. Alternatively, manually export your database via phpMyAdmin and download your site files using FTP. Store backups securely offsite.");
$store->add('help-011', "How do I restore a WordPress backup? Use your backup plugin’s restore feature or manually upload your files and import your database using phpMyAdmin. Make sure your wp-config.php settings match your database credentials.");
$store->add('help-012', "How do I change my WordPress site URL? Go to Settings > General and update the WordPress Address (URL) and Site Address (URL). If you can't access the dashboard, update these values in wp-config.php or the database.");
$store->add('help-013', "How do I enable SSL for my WordPress site? Obtain an SSL certificate from your host, install it, and update your site URL to use https. Use plugins like Really Simple SSL to handle redirects and mixed content.");
$store->add('help-014', "How do I create a child theme in WordPress? Create a new folder in wp-content/themes, add a style.css with a Template header referencing the parent theme, and enqueue the parent theme’s stylesheet in functions.php.");
$store->add('help-015', "How do I optimize WordPress for speed? Use caching plugins, optimize images, enable gzip compression, minimize CSS/JS, and choose fast hosting. Regularly update WordPress, themes, and plugins.");
$store->add('help-016', "How do I disable comments on WordPress posts? Go to Settings > Discussion and uncheck 'Allow people to submit comments'. You can also disable comments for individual posts or use a plugin to disable comments site-wide.");
$store->add('help-017', "How do I create a contact form in WordPress? Install a plugin like Contact Form 7 or WPForms, create a form, and embed it in a page or post using a shortcode.");
$store->add('help-018', "How do I set up WordPress multisite? In wp-config.php, add define('WP_ALLOW_MULTISITE', true); then go to Tools > Network Setup. Follow the instructions to configure your network and update .htaccess.");
$store->add('help-019', "How do I change the WordPress admin username? Create a new user with administrator role, log in as that user, and delete the old admin account. Assign posts to the new user during deletion.");
$store->add('help-020', "How do I fix the 'Error Establishing a Database Connection' in WordPress? Check your wp-config.php for correct database credentials, ensure your database server is running, and repair the database using phpMyAdmin or the WordPress repair tool.");
$store->add('help-031', "How do I set up email notifications in WordPress? Use plugins like WP Mail SMTP to configure outgoing email settings and ensure reliable delivery. Customize notification settings in your form or membership plugins.");
$store->add('help-032', "How do I add social sharing buttons to WordPress posts? Install a plugin like Shared Counts or AddToAny, configure which networks to display, and choose button placement on posts or pages.");
$store->add('help-033', "How do I create custom post types in WordPress? Use a plugin like Custom Post Type UI or add code to your theme’s functions.php using register_post_type(). Customize labels, supports, and visibility.");
$store->add('help-034', "How do I schedule posts in WordPress? In the post editor, click 'Publish immediately', set a future date and time, and click 'Schedule'. WordPress will automatically publish the post at the specified time.");
$store->add('help-035', "How do I add a favicon to my WordPress site? Go to Appearance > Customize > Site Identity, upload your favicon image, and save changes. Alternatively, add a link tag in your theme’s header.php.");
$store->add('help-036', "How do I enable maintenance mode in WordPress? Install a plugin like WP Maintenance Mode, activate it, and customize the maintenance page shown to visitors while you work on your site.");
$store->add('help-037', "How do I add a slider to my WordPress homepage? Install a slider plugin like Smart Slider 3 or MetaSlider, create a slider, and embed it using a shortcode or widget in your homepage layout.");
$store->add('help-038', "How do I limit login attempts in WordPress? Use a security plugin like Limit Login Attempts Reloaded to restrict the number of failed login attempts and protect against brute force attacks.");
$store->add('help-039', "How do I add breadcrumbs navigation to WordPress? Install a plugin like Breadcrumb NavXT or Yoast SEO, configure breadcrumb settings, and display them in your theme using a shortcode or PHP function.");
$store->add('help-040', "How do I create a multilingual WordPress site? Use a plugin like WPML or Polylang to add translations for posts, pages, and menus. Configure language switchers and translate site content as needed.");
