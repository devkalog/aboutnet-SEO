<?php

if (!defined('ABSPATH')) {
    exit;
}

function aboutnet_seo_product_category_has_child_terms(): bool
{
    $current_term = get_queried_object();

    if (!$current_term || empty($current_term->term_id)) {
        return false;
    }

    $child_terms = get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => (int) $current_term->term_id,
        'hide_empty' => false,
    ]);

    return !is_wp_error($child_terms) && !empty($child_terms);
}

function aboutnet_seo_product_category_breadcrumb(): string
{
    if (!is_product_category()) {
        return '';
    }

    $current_term = get_queried_object();

    if (!$current_term || empty($current_term->term_id)) {
        return '';
    }

    $breadcrumb_items = [];

    $breadcrumb_items[] = sprintf(
        '<a href="%s">%s</a>',
        esc_url(home_url('/')),
        esc_html__('Αρχική', 'aboutnet-seo')
    );

    $ancestors = get_ancestors((int) $current_term->term_id, 'product_cat', 'taxonomy');
    $ancestors = array_reverse($ancestors);

    foreach ($ancestors as $ancestor_id) {
        $ancestor = get_term((int) $ancestor_id, 'product_cat');

        if (!$ancestor || is_wp_error($ancestor)) {
            continue;
        }

        $breadcrumb_items[] = sprintf(
            '<a href="%s">%s</a>',
            esc_url(get_term_link($ancestor)),
            esc_html($ancestor->name)
        );
    }

    $breadcrumb_items[] = sprintf(
        '<span>%s</span>',
        esc_html($current_term->name)
    );

    return sprintf(
        '<nav class="op-breadcrumb" aria-label="Breadcrumb">%s</nav>',
        implode(' &rsaquo; ', $breadcrumb_items)
    );
}

function aboutnet_seo_product_category_child_terms_list(WP_Term $current_term): string
{
    $child_terms = get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => (int) $current_term->term_id,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);

    if (is_wp_error($child_terms) || empty($child_terms)) {
        return '';
    }

    $html = '<ul class="op-subcategories">';

    foreach ($child_terms as $child_term) {
        $child_link = get_term_link($child_term);

        if (is_wp_error($child_link)) {
            continue;
        }

        $html .= '<li><a href="' . esc_url($child_link) . '" title="' . esc_attr($child_term->name) . '">' . esc_html($child_term->name) . '</a></li>';
    }

    $html .= '</ul>';

    return $html;
}

function aboutnet_seo_product_category_parent_link(WP_Term $current_term): string
{
    $parent_term_id = (int) $current_term->parent;

    if ($parent_term_id <= 0) {
        return '';
    }

    $parent_term = get_term($parent_term_id, 'product_cat');

    if (!$parent_term || is_wp_error($parent_term)) {
        return '';
    }

    $parent_link = get_term_link($parent_term);

    if (is_wp_error($parent_link)) {
        return '';
    }

    return '<a href="' . esc_url($parent_link) . '" title="' . esc_attr($parent_term->name) . '">' . esc_html($parent_term->name) . '</a>';
}

function aboutnet_seo_product_category_sibling_links(WP_Term $current_term): string
{
    $parent_term_id = (int) $current_term->parent;

    if ($parent_term_id <= 0) {
        return '';
    }

    $sibling_terms = get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => $parent_term_id,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
        'exclude'    => [(int) $current_term->term_id],
    ]);

    if (is_wp_error($sibling_terms) || empty($sibling_terms)) {
        return '';
    }

    $links = [];

    foreach ($sibling_terms as $sibling_term) {
        $sibling_link = get_term_link($sibling_term);

        if (is_wp_error($sibling_link)) {
            continue;
        }

        $links[] = '<a href="' . esc_url($sibling_link) . '" title="' . esc_attr($sibling_term->name) . '">' . esc_html($sibling_term->name) . '</a>';
    }

    return implode(', ', $links);
}