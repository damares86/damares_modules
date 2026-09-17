<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

require __DIR__ . '/coreConfig.php';

$idToDel = filter_input(INPUT_GET, 'idToDel', FILTER_VALIDATE_INT);
if ($idToDel !== false && $idToDel !== null) {
    $customer->id = $idToDel;
    if ($customer->delete('id')) {
        header('Location: ../index.php?p=allCustomers&msg=customerDel');
        exit;
    }

    header('Location: ../index.php?p=allCustomers&err=customerNoDel');
    exit;
}

$operation = (string) (filter_input(INPUT_POST, 'operation', FILTER_DEFAULT) ?? '');

if ($operation === 'edit') {
    $id = (int) (filter_input(INPUT_POST, 'idToMod', FILTER_VALIDATE_INT) ?? 0);
    $url_tablePage = (string) (filter_input(INPUT_POST, 'url_tablePage', FILTER_DEFAULT) ?? '');
    $url_pageName = (string) (filter_input(INPUT_POST, 'url_pageName', FILTER_DEFAULT) ?? '');
    $url_data = '&tablePage=' . urlencode($url_tablePage) . '&pageName=' . urlencode($url_pageName);

    $customer->id = $id;
    $customer->name = (string) (filter_input(INPUT_POST, 'name', FILTER_DEFAULT) ?? '');
    $customer->surname = (string) (filter_input(INPUT_POST, 'surname', FILTER_DEFAULT) ?? '');

    $customers_details = [];
    $customers_details_opt = [];
    if (is_file(__DIR__ . '/customersDetails.php')) {
        require __DIR__ . '/customersDetails.php';
    }

    $details_arr = [];
    $details_opt_arr = [];

    foreach ($customers_details as $item) {
        $val = (string) ($_POST[$item] ?? '');
        $details_arr[] = [$item => $val];
    }
    $customer->details = serialize($details_arr);

    foreach ($customers_details_opt as $item) {
        $val = (string) ($_POST[$item] ?? '');
        $details_opt_arr[] = [$item => $val];
    }
    $customer->details_opt = serialize($details_opt_arr);

    if ($customer->update(['name', 'surname', 'details', 'details_opt'], 'id')) {
        header("Location: ../index.php?p=editCustomer&idToMod={$id}&msg=customerEdit{$url_data}");
        exit;
    }

    header("Location: ../index.php?p=editCustomer&idToMod={$id}&err=customerNoEdit{$url_data}");
    exit;
}

if ($operation === 'add') {
    $customer->name = (string) (filter_input(INPUT_POST, 'name', FILTER_DEFAULT) ?? '');
    $customer->surname = (string) (filter_input(INPUT_POST, 'surname', FILTER_DEFAULT) ?? '');

    if ($customer->customerExists()) {
        header('Location: ../index.php?p=addCustomer&err=customerExist');
        exit;
    }

    $customers_details = [];
    $customers_details_opt = [];
    if (is_file(__DIR__ . '/customersDetails.php')) {
        require __DIR__ . '/customersDetails.php';
    }

    $details_arr = [];
    $details_opt_arr = [];

    foreach ($customers_details as $item) {
        $val = (string) ($_POST[$item] ?? '');
        $details_arr[] = [$item => $val];
    }
    $customer->details = serialize($details_arr);

    foreach ($customers_details_opt as $item) {
        $val = (string) ($_POST[$item] ?? '');
        $details_opt_arr[] = [$item => $val];
    }
    $customer->details_opt = serialize($details_opt_arr);

    if ($customer->insert(['name', 'surname', 'details', 'details_opt'])) {
        header('Location: ../index.php?p=allCustomers&msg=customerSucc');
        exit;
    }

    header('Location: ../index.php?p=allCustomers&err=customerFail');
    exit;
}

header('Location: ../index.php?p=allCustomers&err=noPost');
exit;
