<?php
class Customize_Elementor_Widgets
{

    protected static $instance = null;

    public static function get_instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    protected function __construct()
    {
        // require_once('post-layout-one.php');
        // require_once('shop_masonary.php');
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
    }
    private function include_widgets_files()
    {
        require_once 'mami/post-recent-widget.php';
        require_once 'mami/recent-post-nocat.php';
    }

    public function register_widgets()
    {
        $this->include_widgets_files();
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\recent_customer());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\recent_post_nocat());
    }
}

function yp_core_scripts()
{
    wp_enqueue_script('yp_core', plugin_dir_url(__DIR__) . 'js/yp-main.js', '1.0.0', true);
}
add_action('elementor/frontend/after_enqueue_scripts', 'yp_core_scripts', 20);

function yp_core_scripts_head()
{
    wp_enqueue_script('yp_e_swiper', plugin_dir_url(__DIR__) . 'js/swiper-bundle.min.js', '1.0.0');
}
add_action('wp_enqueue_scripts', 'yp_core_scripts_head', 10);

function wpdocs_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'wpdocs_excerpt_more');

function wpdocs_custom_excerpt_length($length)
{
    return 220;
}
add_filter('excerpt_length', 'wpdocs_custom_excerpt_length', 999);

function carousel_home_banner_styles()
{
    $yp_core_inline = '#carousel_home_banner img{width:100%}#carousel_home_banner .splide__arrow{background:#fefefe;box-shadow:rgb(23 23 23 / 46%) 2px 1px 5px;opacity:1}#carousel_home_banner svg{width:19px;height:40px}#carousel_home_banner .splide__pagination{bottom:17px!important}#carousel_home_banner button.splide__pagination__page{background:#eee!important;box-shadow:rgb(23 23 23 / 19%) 2px 1px 5px;opacity:.9}#carousel_home_banner .splide__pagination__page.is-active{background:#067c70!important}';

    wp_register_style('yp_core_inline', false);
    wp_enqueue_style('yp_core_inline');
    wp_add_inline_style('yp_core_inline', $yp_core_inline);
}
add_action('wp_enqueue_scripts', 'carousel_home_banner_styles');

add_action('init', 'customize_elementor_init');
function customize_elementor_init()
{
    Customize_Elementor_Widgets::get_instance();
}
