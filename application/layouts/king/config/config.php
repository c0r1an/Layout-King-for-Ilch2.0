<?php

/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Layouts\King\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'name' => 'King',
        'version' => '1.0.0',
        'ilchCore' => '2.2.0',
        'author' => 'c0r1an',
        'link' => 'https://teamkill.club',
        'desc' => 'King Layout.',
        'layouts' => [
            'index_full' => [
                ['module' => 'user', 'controller' => 'panel'],
                ['module' => 'forum'],
                ['module' => 'guestbook'],
            ],
        ],
        'settings' => [
            'basic_settings' => [
                'type' => 'separator',
            ],
            'site_logo' => [
                'type' => 'mediaselection',
                'default' => '',
                'description' => 'desc_site_logo',
            ],
            'accent_color' => [
                'type' => 'colorpicker',
                'default' => '#ef3418',
                'description' => 'desc_accent_color',
            ],
            'content_width' => [
                'type' => 'text',
                'default' => '1100',
                'description' => 'desc_content_width',
            ],
            'header_settings' => [
                'type' => 'separator',
            ],
            'header_banner_left' => [
                'type' => 'mediaselection',
                'default' => '',
                'description' => 'desc_header_banner_left',
            ],
            'header_banner_left_url' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_header_banner_left_url',
            ],
            'header_banner_left_blank' => [
                'type' => 'flipswitch',
                'default' => '0',
                'description' => 'desc_header_banner_left_blank',
            ],
            'header_banner_right' => [
                'type' => 'mediaselection',
                'default' => '',
                'description' => 'desc_header_banner_right',
            ],
            'header_banner_right_url' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_header_banner_right_url',
            ],
            'header_banner_right_blank' => [
                'type' => 'flipswitch',
                'default' => '0',
                'description' => 'desc_header_banner_right_blank',
            ],
            'navigation_settings' => [
                'type' => 'separator',
            ],
            'social_facebook' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_social_facebook',
            ],
            'social_youtube' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_social_youtube',
            ],
            'social_twitter' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_social_twitter',
            ],
            'social_instagram' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_social_instagram',
            ],
            'social_twitch' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_social_twitch',
            ],
            'social_rss' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_social_rss',
            ],
            'slider_settings' => [
                'type' => 'separator',
            ],
            'slider_1_image' => [
                'type' => 'mediaselection',
                'default' => '',
                'description' => 'desc_slider_image',
            ],
            'slider_1_title' => [
                'type' => 'text',
                'default' => 'Welcome to King',
                'description' => 'desc_slider_title',
            ],
            'slider_1_text' => [
                'type' => 'text',
                'default' => 'Manage this slide in the layout advanced settings.',
                'description' => 'desc_slider_text',
            ],
            'slider_1_url' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_slider_url',
            ],
            'slider_1_blank' => [
                'type' => 'flipswitch',
                'default' => '0',
                'description' => 'desc_slider_blank',
            ],
            'slider_2_image' => [
                'type' => 'mediaselection',
                'default' => '',
                'description' => 'desc_slider_image',
            ],
            'slider_2_title' => [
                'type' => 'text',
                'default' => 'Second Slide',
                'description' => 'desc_slider_title',
            ],
            'slider_2_text' => [
                'type' => 'text',
                'default' => 'Add your own image, text and link for the second slide.',
                'description' => 'desc_slider_text',
            ],
            'slider_2_url' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_slider_url',
            ],
            'slider_2_blank' => [
                'type' => 'flipswitch',
                'default' => '0',
                'description' => 'desc_slider_blank',
            ],
            'slider_3_image' => [
                'type' => 'mediaselection',
                'default' => '',
                'description' => 'desc_slider_image',
            ],
            'slider_3_title' => [
                'type' => 'text',
                'default' => 'Third Slide',
                'description' => 'desc_slider_title',
            ],
            'slider_3_text' => [
                'type' => 'text',
                'default' => 'The slider width follows the content width setting.',
                'description' => 'desc_slider_text',
            ],
            'slider_3_url' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_slider_url',
            ],
            'slider_3_blank' => [
                'type' => 'flipswitch',
                'default' => '0',
                'description' => 'desc_slider_blank',
            ],
            'footer_settings' => [
                'type' => 'separator',
            ],
            'footer_links_title' => [
                'type' => 'text',
                'default' => 'Wichtige Links',
                'description' => 'desc_footer_links_title',
            ],
            'footer_link_1_text' => [
                'type' => 'text',
                'default' => '',
                'description' => 'desc_footer_link_text',
            ],
            'footer_link_1_url' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_footer_link_url',
            ],
            'footer_link_2_text' => [
                'type' => 'text',
                'default' => '',
                'description' => 'desc_footer_link_text',
            ],
            'footer_link_2_url' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_footer_link_url',
            ],
            'footer_link_3_text' => [
                'type' => 'text',
                'default' => '',
                'description' => 'desc_footer_link_text',
            ],
            'footer_link_3_url' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_footer_link_url',
            ],
            'footer_link_4_text' => [
                'type' => 'text',
                'default' => '',
                'description' => 'desc_footer_link_text',
            ],
            'footer_link_4_url' => [
                'type' => 'url',
                'default' => '',
                'description' => 'desc_footer_link_url',
            ],
            'footer_copyright_text' => [
                'type' => 'text',
                'default' => '%YEAR% %TITLE% Inc. - All Rights Reserved.',
                'description' => 'desc_footer_copyright_text',
            ],
        ],
    ];

    public function getUpdate($installedVersion)
    {
    }
}
