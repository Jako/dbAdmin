<?php
/**
 * Setup options
 *
 * @package dbadmin
 * @subpackage build
 *
 * @var array $options
 */

$output = '<style type="text/css">
    #modx-setupoptions-panel { display: none; }
    #modx-setupoptions-form p { margin-bottom: 10px; }
    #modx-setupoptions-form h2 { margin-bottom: 15px; }
</style>';

$values = [];
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        $output .= '<h2>Install dbAdmin</h2>

        <p>Thanks for installing dbAdmin. This open source extra is
        maintained by Treehill Studio - MODX development in Münsterland.</p>

        <p>During the installation, we will collect some statistical data (the
        hostname, the MODX UUID, the PHP version and the MODX version of your
        MODX installation). Your data will be kept confidential and under no
        circumstances be used for promotional purposes or disclosed to third
        parties.</p>
        
        <p>If you install this package, you are giving us your permission to
        collect, process and use that data for statistical purposes.</p>';

        break;
    case xPDOTransport::ACTION_UPGRADE:
        $output .= '<h2>Upgrade dbAdmin</h2>

        <p>dbAdmin will be upgraded. This open source extra is maintained by
        Treehill Studio - MODX development in Münsterland.</p>

        During the upgrade, we will collect some statistical data (the hostname,
        the MODX UUID, the PHP version, the MODX version of your MODX
        installation and the previous installed version of this extra package).
        Your data will be kept confidential and under no circumstances be used
        for promotional purposes or disclosed to third parties.</p>

        <p>If you upgrade this package, you are giving us your permission to
        collect, process and use that data for statistical purposes.</p>';

        break;
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return $output;
