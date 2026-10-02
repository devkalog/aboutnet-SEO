<?php
/**
 * Plugin Name: Aboutnet SEO
 * Plugin URI: https://aboutnet.gr/
 * Description: SEO plugin by Aboutnet.
 * Version: 1.0.0
 * Author: aboutnet.gr
 * Author URI: https://aboutnet.gr/
 * Text Domain: aboutnet-seo
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ABOUTNET_SEO_VERSION', '1.0.0');
define('ABOUTNET_SEO_FILE', __FILE__);
define('ABOUTNET_SEO_PATH', plugin_dir_path(__FILE__));
define('ABOUTNET_SEO_URL', plugin_dir_url(__FILE__));

require_once ABOUTNET_SEO_PATH . 'functions.php';
require_once ABOUTNET_SEO_PATH . 'inc.php';

final class Aboutnet_SEO
{
    private static ?Aboutnet_SEO $instance = null;

    public static function instance(): Aboutnet_SEO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init(): void
    {
        add_action('woocommerce_after_shop_loop', [$this, 'display_after_product_loop'], 20);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function display_after_product_loop(): void
    {
        if (!is_product_category())
        {
            return;
        }

        $current_term = get_queried_object();

        if (!$current_term || empty($current_term->term_id))
        {
            return;
        }

        $category_title = $current_term->name;
        $seo_intro = get_term_meta((int) $current_term->term_id, 'seo-intro', true);
        $seo_range = get_term_meta((int) $current_term->term_id, 'seo-range', true);
        $seo_interest = get_term_meta((int) $current_term->term_id, 'seo-interest', true);
        $seo_related_enabled = get_term_meta((int) $current_term->term_id, 'seo-related-enabled', true);
        $to_home = aboutnet_seo_product_category_parent_link($current_term);
        if($to_home)
        {
            $similar_categories = aboutnet_seo_product_category_sibling_links($current_term);
        }
        $has_child_terms = aboutnet_seo_product_category_has_child_terms();

        echo '<div class="aboutnet-seo-content">';
            echo aboutnet_seo_product_category_breadcrumb();
            if ($has_child_terms)
            {
                echo '<p class=""op-intro"">Εξερευνήστε τη μεγάλη συλλογή <strong>' . esc_html($category_title) . '</strong> του OnPharm, με προϊόντα από τις κορυφαίες εταιρείες του κλάδου και ειδικές τιμές σε όλες τις υποκατηγορίες.</p>';
                echo '<h2>Υποκατηγορίες ' . esc_html($category_title) . '</h2>';
                echo aboutnet_seo_product_category_child_terms_list($current_term);
            }
            else
            {
                echo '<p class=""op-intro"">' . wp_kses_post($seo_intro) . '</p>';
            }
            if($seo_range)
            {
                echo wp_kses_post($seo_range);
            }
            echo '<div class=""op-benefits"">
                <h3>Γιατί να επιλέξετε το OnPharm.gr;</h3>
                <ul>
                    <li><strong>Γνήσια προϊόντα</strong> από πιστοποιημένους προμηθευτές</li>
                    <li><strong>Ειδικές τιμές</strong> online φαρμακείου σε όλες τις κατηγορίες</li>
                    <li><strong>Άμεση αποστολή</strong> σε όλη την Ελλάδα</li>
                    <li><strong>Καθοδήγηση</strong> από έμπειρο φαρμακοποιό</li>
                    <li><strong>Ασφαλείς συναλλαγές</strong> και εύκολη διαδικασία αγοράς</li>
                </ul>
            </div>';
            if($seo_related_enabled == '1')
            {
                echo '<div class="op-related-links">
                        <h3>Σχετικά στο OnPharm</h3>';
                if($to_home)
                {
                    echo '<p>Επιστροφή στην κεντρική κατηγορία: ' . $to_home . '</p>';
                    if($similar_categories)
                    {
                        echo '<p><strong>Σχετικές κατηγορίες:</strong> ';
                        echo $similar_categories;
                        echo '</p>';
                    }
                }
                if($seo_interest)
                {
                    echo '<p><strong>Μπορεί να σας ενδιαφέρουν:</strong> ';
                    echo wp_kses_post($seo_interest);
                }
                echo '</div>';
            }

        echo '</div>';
    }

    public function enqueue_assets(): void
    {
        if (!is_product_category()) {
            return;
        }

        wp_enqueue_style(
            'aboutnet-seo',
            ABOUTNET_SEO_URL . 'css/aboutnet-seo.css',
            [],
            ABOUTNET_SEO_VERSION
        );
    }
}

function aboutnet_seo(): Aboutnet_SEO
{
    return Aboutnet_SEO::instance();
}

aboutnet_seo();