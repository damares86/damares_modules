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
    // remove all pazienti_farmaci records
    $rsa->id_pazienti = $idToDel;
    $rsa->table = 'pazienti_farmaci';
    $stmt = $rsa->showAllWhere('id', ['id_pazienti']);

    $error = 0;
    if ($stmt instanceof PDOStatement) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rsa->table = 'pazienti_farmaci';
            $rsa->id = (int) ($row['id'] ?? 0);

            if (!$rsa->delete('id')) {
                $error++;
            }
        }
    }

    if ($error === 0) {
        $rsa->id = $idToDel;
        $rsa->table = 'pazienti';

        if ($rsa->delete('id')) {
            header('Location: ../index.php?p=allPazienti&msg=pazienteDel');
            exit;
        }

        header('Location: ../index.php?p=allPazienti&err=pazienteNoDel');
        exit;
    }

    header('Location: ../index.php?p=allPazienti&err=pazienteFarmaciNoDel');
    exit;
}

$idToMod = filter_input(INPUT_POST, 'idToMod', FILTER_VALIDATE_INT);
$operation = (string) (filter_input(INPUT_POST, 'operation', FILTER_DEFAULT) ?? '');

if ($idToMod !== false && $idToMod !== null) {
    $url_tablePage = (string) (filter_input(INPUT_POST, 'url_tablePage', FILTER_DEFAULT) ?? '');
    $url_pageName = (string) (filter_input(INPUT_POST, 'url_pageName', FILTER_DEFAULT) ?? '');
    $url_data = '&tablePage=' . urlencode($url_tablePage) . '&pageName=' . urlencode($url_pageName);

    if ($operation === 'edit') {
        $rsa->table = 'pazienti';
        $rsa->id = $idToMod;
        $rsa->nome = (string) (filter_input(INPUT_POST, 'nome', FILTER_DEFAULT) ?? '');
        $rsa->cognome = (string) (filter_input(INPUT_POST, 'cognome', FILTER_DEFAULT) ?? '');

        if ($rsa->update(['cognome', 'nome'], 'id')) {
            $counter = (int) ($_POST['counter'] ?? 0);
            $error = 0;

            for ($i = 1; $i <= $counter; $i++) {
                $rsa->table = 'pazienti_farmaci';
                $rsa->id_pazienti = $idToMod;
                $rsa->id_farmaci = filter_input(INPUT_POST, 'farmaco_' . $i, FILTER_VALIDATE_INT);

                $stmt = $rsa->showAllWhere('id', ['id_pazienti', 'id_farmaci']);
                $row = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
                if (!$row) {
                    continue;
                }

                $id_pazientiFarmaci = (int) $row['id'];

                if (filter_input(INPUT_POST, 'del_' . $i, FILTER_DEFAULT)) {
                    $rsa->table = 'pazienti_farmaci';
                    $rsa->id = $id_pazientiFarmaci;

                    if (!$rsa->delete('id')) {
                        $error++;
                    }
                } else {
                    $rsa->table = 'pazienti_farmaci';
                    $rsa->id = $id_pazientiFarmaci;
                    $rsa->id_pazienti = $idToMod;
                    $rsa->id_farmaci = filter_input(INPUT_POST, 'farmaco_' . $i, FILTER_VALIDATE_INT);
                    $rsa->cpr = filter_input(INPUT_POST, 'cpr_' . $i, FILTER_VALIDATE_FLOAT);
                    $rsa->magazzino = filter_input(INPUT_POST, 'magazzino_' . $i, FILTER_VALIDATE_INT);

                    if (!$rsa->update(['id_pazienti', 'id_farmaci', 'cpr', 'magazzino'], 'id')) {
                        $error++;
                    }
                }
            }

            if ($error === 0) {
                header("Location: ../index.php?p=editPaziente&idToMod={$idToMod}&msg=pazientiEdit{$url_data}");
                exit;
            }

            header("Location: ../index.php?p=allPazienti&err=farmaciPazientiEditErr{$url_data}");
            exit;
        }

        header("Location: ../index.php?p=allPazienti&err=pazientiNoEdit{$url_data}");
        exit;
    }

    if ($operation === 'addFarmaco') {
        $rsa->table = 'pazienti_farmaci';
        $rsa->id_pazienti = $idToMod;
        $rsa->id_farmaci = filter_input(INPUT_POST, 'farmaco', FILTER_VALIDATE_INT);
        $rsa->cpr = filter_input(INPUT_POST, 'cpr', FILTER_VALIDATE_FLOAT);
        $rsa->magazzino = filter_input(INPUT_POST, 'magazzino', FILTER_VALIDATE_INT) ?? 0;

        if ($rsa->insert(['id_pazienti', 'id_farmaci', 'cpr', 'magazzino'])) {
            header("Location: ../index.php?p=editPaziente&idToMod={$idToMod}&msg=pazientiFarmaciAddSucc{$url_data}");
            exit;
        }

        header("Location: ../index.php?p=editPaziente&idToMod={$idToMod}&err=pazientiFarmaciAddFail{$url_data}");
        exit;
    }
}

if ($operation === 'add') {
    $rsa->table = 'pazienti';
    $rsa->nome = (string) (filter_input(INPUT_POST, 'nome', FILTER_DEFAULT) ?? '');
    $rsa->cognome = (string) (filter_input(INPUT_POST, 'cognome', FILTER_DEFAULT) ?? '');

    if ($rsa->insert(['cognome', 'nome'])) {
        $stmt = $rsa->showAllWhere('id', ['nome', 'cognome']);
        $row = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
        $idPaziente = (int) ($row['id'] ?? 0);

        if (filter_input(INPUT_POST, 'cpr', FILTER_VALIDATE_FLOAT)) {
            $rsa->table = 'pazienti_farmaci';
            $rsa->id_pazienti = $idPaziente;
            $rsa->id_farmaci = filter_input(INPUT_POST, 'farmaco', FILTER_VALIDATE_INT);
            $rsa->magazzino = filter_input(INPUT_POST, 'magazzino', FILTER_VALIDATE_INT) ?? 0;
            $rsa->cpr = filter_input(INPUT_POST, 'cpr', FILTER_VALIDATE_FLOAT);

            if ($rsa->insert(['id_pazienti', 'id_farmaci', 'cpr', 'magazzino'])) {
                header("Location: ../index.php?p=editPaziente&idToMod={$idPaziente}&msg=pazientiAddSucc");
                exit;
            }

            header('Location: ../index.php?p=allPazienti&err=farmaciPazientiErr');
            exit;
        }

        header("Location: ../index.php?p=editPaziente&idToMod={$idPaziente}&msg=pazientiAddSucc");
        exit;
    }

    header('Location: ../index.php?p=allPazienti&err=pazientiAddFail');
    exit;
}

header('Location: ../index.php?p=allPazienti&err=noPost');
exit;
