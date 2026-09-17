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
    $rsa->id_farmaci = $idToDel;
    $rsa->table = 'pazienti_farmaci';
    $stmt = $rsa->showAllWhere('id', ['id_farmaci']);
    $count = $stmt ? $stmt->rowCount() : 0;

    if ($count > 0) {
        header('Location: ../index.php?p=allFarmaci&err=farmaciPazientiExists');
        exit;
    }

    $rsa->id = $idToDel;
    $rsa->table = 'farmaci';

    if ($rsa->delete('id')) {
        header('Location: ../index.php?p=allFarmaci&msg=farmaciDel');
        exit;
    }

    header('Location: ../index.php?p=allFarmaci&err=farmaciNoDel');
    exit;
}

$idToMod = filter_input(INPUT_POST, 'idToMod', FILTER_VALIDATE_INT);
if ($idToMod !== false && $idToMod !== null) {
    $rsa->id = $idToMod;

    $url_tablePage = (string) (filter_input(INPUT_POST, 'url_tablePage', FILTER_DEFAULT) ?? '');
    $url_pageName = (string) (filter_input(INPUT_POST, 'url_pageName', FILTER_DEFAULT) ?? '');
    $url_data = '&tablePage=' . urlencode($url_tablePage) . '&pageName=' . urlencode($url_pageName);

    $rsa->principio = (string) (filter_input(INPUT_POST, 'principio', FILTER_DEFAULT) ?? '');
    $rsa->cpr_box = filter_input(INPUT_POST, 'cpr_box', FILTER_VALIDATE_INT);
    $rsa->table = 'farmaci';

    if ($rsa->update(['principio', 'cpr_box'], 'id')) {
        header("Location: ../index.php?p=allFarmaci&msg=farmaciEdit{$url_data}");
        exit;
    }

    header("Location: ../index.php?p=allFarmaci&err=farmaciNoEdit{$url_data}");
    exit;
}

$operation = (string) (filter_input(INPUT_POST, 'operation', FILTER_DEFAULT) ?? '');

if ($operation === 'add') {
    $rsa->principio = (string) (filter_input(INPUT_POST, 'principio', FILTER_DEFAULT) ?? '');
    $rsa->cpr_box = filter_input(INPUT_POST, 'cpr_box', FILTER_VALIDATE_INT);
    $rsa->table = 'farmaci';

    if ($rsa->insert(['principio', 'cpr_box'])) {
        header('Location: ../index.php?p=allFarmaci&msg=farmaciAddSucc');
        exit;
    }

    header('Location: ../index.php?p=allFarmaci&err=farmaciAddFail');
    exit;
}

header('Location: ../index.php?p=allFarmaci&err=noPost');
exit;