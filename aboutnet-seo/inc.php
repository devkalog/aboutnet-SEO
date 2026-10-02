<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('product_cat_add_form_fields', 'aboutnet_seo_add_seo_intro_field');
add_action('product_cat_edit_form_fields', 'aboutnet_seo_edit_seo_intro_field');

add_action('created_product_cat', 'aboutnet_seo_save_seo_intro_field');
add_action('edited_product_cat', 'aboutnet_seo_save_seo_intro_field');

function aboutnet_seo_add_seo_intro_field(): void
{
    ?>
    <div class="form-field term-seo-intro-wrap">
        <label for="aboutnet_seo_intro">SEO Intro</label>
        <textarea
            name="aboutnet_seo_intro"
            id="aboutnet_seo_intro"
            rows="4"
            class="large-text"
        ></textarea>
        <p class="description">Small intro text for this product category.</p>
    </div>
    <?php
}

function aboutnet_seo_edit_seo_intro_field(WP_Term $term): void
{
    $seo_intro = get_term_meta($term->term_id, 'seo-intro', true);
    ?>
    <tr class="form-field term-seo-intro-wrap">
        <th scope="row">
            <label for="aboutnet_seo_intro">SEO Intro</label>
        </th>
        <td>
            <textarea
                name="aboutnet_seo_intro"
                id="aboutnet_seo_intro"
                rows="4"
                class="large-text"
            ><?php echo esc_textarea($seo_intro); ?></textarea>
            <p class="description">Small intro text for this product category.</p>
        </td>
    </tr>
    <?php
}

function aboutnet_seo_save_seo_intro_field(int $term_id): void
{
    if (!isset($_POST['aboutnet_seo_intro'])) {
        return;
    }

    update_term_meta(
        $term_id,
        'seo-intro',
        wp_kses_post(wp_unslash($_POST['aboutnet_seo_intro']))
    );
}

add_action('product_cat_add_form_fields', 'aboutnet_seo_add_seo_range_field');
add_action('product_cat_edit_form_fields', 'aboutnet_seo_edit_seo_range_field');

add_action('created_product_cat', 'aboutnet_seo_save_seo_range_field');
add_action('edited_product_cat', 'aboutnet_seo_save_seo_range_field');

function aboutnet_seo_add_seo_range_field(): void
{
    ?>
    <div class="form-field term-seo-range-wrap">
        <label for="aboutnet_seo_range">SEO Range</label>
        <textarea
            name="aboutnet_seo_range"
            id="aboutnet_seo_range"
            rows="4"
            class="large-text"
        ></textarea>
        <p class="description">Range text for this product category.</p>
    </div>
    <?php
}

function aboutnet_seo_edit_seo_range_field(WP_Term $term): void
{
    $seo_range = get_term_meta($term->term_id, 'seo-range', true);
    ?>
    <tr class="form-field term-seo-range-wrap">
        <th scope="row">
            <label for="aboutnet_seo_range">SEO Range</label>
        </th>
        <td>
            <textarea
                name="aboutnet_seo_range"
                id="aboutnet_seo_range"
                rows="4"
                class="large-text"
            ><?php echo esc_textarea($seo_range); ?></textarea>
            <p class="description">Range text for this product category.</p>
        </td>
    </tr>
    <?php
}

function aboutnet_seo_save_seo_range_field(int $term_id): void
{
    if (!isset($_POST['aboutnet_seo_range'])) {
        return;
    }

    update_term_meta(
        $term_id,
        'seo-range',
        wp_kses_post(wp_unslash($_POST['aboutnet_seo_range']))
    );
}

add_action('product_cat_add_form_fields', 'aboutnet_seo_add_seo_interest_field');
add_action('product_cat_edit_form_fields', 'aboutnet_seo_edit_seo_interest_field');

add_action('created_product_cat', 'aboutnet_seo_save_seo_interest_field');
add_action('edited_product_cat', 'aboutnet_seo_save_seo_interest_field');

function aboutnet_seo_add_seo_interest_field(): void
{
    ?>
    <div class="form-field term-seo-interest-wrap">
        <label for="aboutnet_seo_interest">SEO Interest</label>
        <textarea
            name="aboutnet_seo_interest"
            id="aboutnet_seo_interest"
            rows="4"
            class="large-text"
        ></textarea>
        <p class="description">Interest text for this product category.</p>
    </div>
    <?php
}

function aboutnet_seo_edit_seo_interest_field(WP_Term $term): void
{
    $seo_interest = get_term_meta($term->term_id, 'seo-interest', true);
    ?>
    <tr class="form-field term-seo-interest-wrap">
        <th scope="row">
            <label for="aboutnet_seo_interest">SEO Interest</label>
        </th>
        <td>
            <textarea
                name="aboutnet_seo_interest"
                id="aboutnet_seo_interest"
                rows="4"
                class="large-text"
            ><?php echo esc_textarea($seo_interest); ?></textarea>
            <p class="description">Interest text for this product category.</p>
        </td>
    </tr>
    <?php
}

function aboutnet_seo_save_seo_interest_field(int $term_id): void
{
    if (!isset($_POST['aboutnet_seo_interest'])) {
        return;
    }

    update_term_meta(
        $term_id,
        'seo-interest',
        wp_kses_post(wp_unslash($_POST['aboutnet_seo_interest']))
    );
}

add_action('product_cat_add_form_fields', 'aboutnet_seo_add_seo_related_enabled_field');
add_action('product_cat_edit_form_fields', 'aboutnet_seo_edit_seo_related_enabled_field');

add_action('created_product_cat', 'aboutnet_seo_save_seo_related_enabled_field');
add_action('edited_product_cat', 'aboutnet_seo_save_seo_related_enabled_field');

function aboutnet_seo_add_seo_related_enabled_field(): void
{
    ?>
    <div class="form-field term-seo-related-enabled-wrap">
        <label>
            <input
                type="checkbox"
                name="aboutnet_seo_related_enabled"
                value="1"
            >
            SEO Related Enabled
        </label>
        <p class="description">Enable related categories section.</p>
    </div>
    <?php
}

function aboutnet_seo_edit_seo_related_enabled_field(WP_Term $term): void
{
    $value = get_term_meta($term->term_id, 'seo-related-enabled', true);
    ?>
    <tr class="form-field term-seo-related-enabled-wrap">
        <th scope="row">SEO Related Enabled</th>
        <td>
            <label>
                <input
                    type="checkbox"
                    name="aboutnet_seo_related_enabled"
                    value="1"
                    <?php checked($value, '1'); ?>
                >
                Enable related categories section.
            </label>
        </td>
    </tr>
    <?php
}

function aboutnet_seo_save_seo_related_enabled_field(int $term_id): void
{
    $value = isset($_POST['aboutnet_seo_related_enabled']) ? '1' : '0';

    update_term_meta($term_id, 'seo-related-enabled', $value);
}