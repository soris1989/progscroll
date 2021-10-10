<h1>ProgScroll Settings</h1>
<?php settings_errors(); ?>

<div class="form-errors"></div>
<form id="settings-form" action="options.php" method="post">
    <?php
        // id of options_group we generated before
        // in Admin.php
        settings_fields( 'progscroll_plugin_settings' );

        // we need to pass the menu slug of the page 
        // where the settings' section are applied to
        do_settings_sections( 'progscroll_plugin' );

        // generate the submit button for us
        submit_button();
    ?>
</form>