<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://codetot.com
 * @since      1.0.0
 *
 * @package    Codetot_Optimization
 * @subpackage Codetot_Optimization/admin/partials
 */
$this->ct_optimization_options = get_option( 'ct_optimization_option_name' ); ?>

<div class="wrap">
    <h2><?php esc_html_e('CT Optimization', 'ct-optimization'); ?></h2>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php
        settings_fields( 'ct_optimization_option_group' );
        do_settings_sections( 'ct-optimization-admin' );
        submit_button();
        ?>
    </form>
</div>
