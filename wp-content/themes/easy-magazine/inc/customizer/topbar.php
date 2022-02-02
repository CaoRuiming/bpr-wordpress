<?php

$default = easy_magazine_get_default_theme_options();
/**
* Add Header Top Panel
*/
$wp_customize->add_panel( 'header_top_panel', array(
    'title'          => __( 'Header Top', 'easy-magazine' ),
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
) );

/** Header contact info section */
$wp_customize->add_section(
    'header_contact_info_section',
    array(
        'title'    => __( 'Contact Info', 'easy-magazine' ),
        'panel'    => 'header_top_panel',
        'priority' => 10,
    )
);

/** Header contact info control */
$wp_customize->add_setting( 
    'theme_options[show_header_contact_info]', 
    array(
        'default'           => $default['show_header_contact_info'],
        'sanitize_callback' => 'easy_magazine_sanitize_checkbox',
    ) 
);

$wp_customize->add_control(
    'theme_options[show_header_contact_info]',
    array(
        'label'       => __( 'Show Contact Info', 'easy-magazine' ),
        'section'     => 'header_contact_info_section',
        'type'        => 'checkbox',
    )
);

/** Location */
$wp_customize->add_setting( 'theme_options[header_location]', array(
    'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control(
    'theme_options[header_location]',
    array(
        'label'           => __( 'Location', 'easy-magazine' ),
        'description'     => __( 'Enter Location.', 'easy-magazine' ),
        'section'         => 'header_contact_info_section',
        'active_callback' => 'easy_magazine_contact_info_ac',
    )
);

/** Phone */
$wp_customize->add_setting( 'theme_options[header_phone]', array(
    'sanitize_callback' => 'easy_magazine_sanitize_phone_number',
) );

$wp_customize->add_control(
    'theme_options[header_phone]',
    array(
        'label'           => __( 'Phone', 'easy-magazine' ),
        'description'     => __( 'Enter phone number.', 'easy-magazine' ),
        'section'         => 'header_contact_info_section',
        'active_callback' => 'easy_magazine_contact_info_ac',
    )
);

/** Email */
$wp_customize->add_setting( 
    'theme_options[header_email]', 
    array(
        'sanitize_callback' => 'sanitize_email',
    ) 
);

$wp_customize->add_control(
    'theme_options[header_email]',
    array(
        'label'           => __( 'Email', 'easy-magazine' ),
        'description'     => __( 'Enter valid email address.', 'easy-magazine' ),
        'section'         => 'header_contact_info_section',
        'active_callback' => 'easy_magazine_contact_info_ac',
    )
);

/** Header social links section */
$wp_customize->add_section(
    'header_social_links_section',
    array(
        'title'    => __( 'Social Links', 'easy-magazine' ),
        'panel'    => 'header_top_panel',
        'priority' => 20,
    )
);

/** Header social links control */
$wp_customize->add_setting( 
    'theme_options[show_header_social_links]', 
    array(
        'default'           => $default['show_header_social_links'],
        'sanitize_callback' => 'easy_magazine_sanitize_checkbox',
    ) 
);

$wp_customize->add_control(
    'theme_options[show_header_social_links]',
    array(
        'label'       => __( 'Show Social Links', 'easy-magazine' ),
        'section'     => 'header_social_links_section',
        'type'        => 'checkbox',
    )
);

// Setting social_links.
$wp_customize->add_setting( 
    'theme_options[social_link_1]', 
    array(
        'sanitize_callback' => 'esc_url_raw',
    ) 
);

$wp_customize->add_control(
    'theme_options[social_link_1]',
    array(
        'label'           => __( 'Social Link 1', 'easy-magazine' ),
        'description'     => __( 'Enter valid url.', 'easy-magazine' ),
        'section'         => 'header_social_links_section',
        'type'            => 'url',
        'active_callback' => 'easy_magazine_social_links_active',
    )
);

$wp_customize->add_setting( 
    'theme_options[social_link_2]', 
    array(
        'sanitize_callback' => 'esc_url_raw',
    ) 
);

$wp_customize->add_control(
    'theme_options[social_link_2]',
    array(
        'label'           => __( 'Social Link 2', 'easy-magazine' ),
        'description'     => __( 'Enter valid url.', 'easy-magazine' ),
        'section'         => 'header_social_links_section',
        'type'            => 'url',
        'active_callback' => 'easy_magazine_social_links_active',
    )
);
$wp_customize->add_setting( 
    'theme_options[social_link_3]', 
    array(
        'sanitize_callback' => 'esc_url_raw',
    ) 
);

$wp_customize->add_control(
    'theme_options[social_link_3]',
    array(
        'label'           => __( 'Social Link 3', 'easy-magazine' ),
        'description'     => __( 'Enter valid url.', 'easy-magazine' ),
        'section'         => 'header_social_links_section',
        'type'            => 'url',
        'active_callback' => 'easy_magazine_social_links_active',
    )
);

// Advertisement Section
$wp_customize->add_section(
    'header_advertisement_section',
    array(
        'title'    => __( 'Advertisement', 'easy-magazine' ),
        'panel'    => 'header_top_panel',
        'priority' => 20,
    )
);

// Advertisement Image
$wp_customize->add_setting( 'theme_options[advertisement_image]', array(
    'sanitize_callback' => 'easy_magazine_sanitize_image'
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'theme_options[advertisement_image]',
    array(
        'label'             => esc_html__( 'Advertisement Image', 'easy-magazine' ),
        'description'       => sprintf( esc_html__( 'Recommended size: 800px x 90px ', 'easy-magazine' ), 810, 120 ),
        'section'           => 'header_advertisement_section',
    ) 
) );

// Advertisement Link
$wp_customize->add_setting( 'theme_options[advertisement_url]', array(
    'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( 'theme_options[advertisement_url]', array(
    'label'             => esc_html__( 'Advertisement Url', 'easy-magazine' ),
    'section'           => 'header_advertisement_section',
    'type'              => 'url',
) );