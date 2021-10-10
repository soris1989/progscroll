<?php
    $option = get_option( 'progscroll_plugin' );

    $active = isset($option['active']) ? $option['active'] : false;
    $position_xs = isset($option['position_xs']) ? $option['position_xs'] : null;
    $position_sm = isset($option['position_sm']) ? $option['position_sm'] : null;
    $position_md = isset($option['position_md']) ? $option['position_md'] : null;
    $position_lg = isset($option['position_lg']) ? $option['position_lg'] : null;
    $position_xl = isset($option['position_xl']) ? $option['position_xl'] : null;
    $position_xs_unit = isset($option['position_xs_unit']) ? $option['position_xs_unit'] : null;
    $position_sm_unit = isset($option['position_sm_unit']) ? $option['position_sm_unit'] : null;
    $position_md_unit = isset($option['position_md_unit']) ? $option['position_md_unit'] : null;
    $position_lg_unit = isset($option['position_lg_unit']) ? $option['position_lg_unit'] : null;
    $position_xl_unit = isset($option['position_xl_unit']) ? $option['position_xl_unit'] : null;
    
    $thickness = isset($option['thickness']) ? $option['thickness'] : null;
    $thickness_unit = isset($option['thickness_unit']) ? $option['thickness_unit'] : null;
    $color = isset($option['color']) ? $option['color'] : null;
    $z_index = isset($option['z_index']) ? $option['z_index'] : null;
    $direction = isset($option['direction']) ? $option['direction'] : null;
?>


<?php if ($active) { ?>
<div id="progscroll" class="progscroll <?= $direction ?>" data-color="<?= $color ?>" data-z-index="<?= $z_index ?>"
    data-direction="<?= $direction ?>" data-thickness="<?= $thickness ?>" data-thickness-unit="<?= $thickness_unit ?>" 
    data-position-xs="<?= $position_xs ?>" data-position-xs-unit="<?= $position_xs_unit ?>"
    data-position-sm="<?= $position_sm ?>" data-position-sm-unit="<?= $position_sm_unit ?>"
    data-position-md="<?= $position_md ?>" data-position-md-unit="<?= $position_md_unit ?>"
    data-position-lg="<?= $position_lg ?>" data-position-lg-unit="<?= $position_lg_unit ?>"
    data-position-xl="<?= $position_xl ?>" data-position-xl-unit="<?= $position_xl_unit ?>"
    >
</div>
<?php } ?>