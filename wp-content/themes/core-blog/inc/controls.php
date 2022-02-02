<?php
/**
 * excerpt lenth.
 */
if (!class_exists('WP_Customize_Control'))
{
    return null;
}


function core_blog_sanitize_select($input, $setting)
{
    // Ensure input is a slug.
    $input = sanitize_key($input);

    // Get list of choices from the control associated with the setting.
    $choices = $setting
        ->manager
        ->get_control($setting->id)->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

function core_blog_sanitize_checkbox($checked)
{
    return ((isset($checked) && true === $checked) ? true : false);
}