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

$rsa->table = 'farmaci';
$stmt = $rsa->showAll('id');

$ordine = [];

$array_month = [
    '01' => 31,
    '02' => 28,
    '03' => 31,
    '04' => 30,
    '05' => 31,
    '06' => 30,
    '07' => 31,
    '08' => 31,
    '09' => 30,
    '10' => 31,
    '11' => 30,
    '12' => 31,
];

$mese = (string) (filter_input(INPUT_POST, 'mese', FILTER_DEFAULT) ?? date('m'));
$giorni = $array_month[$mese] ?? 30;

$anno = (int) date('Y');
$bisestile = $rsa->is_leap_year($anno);
if ($mese === '02' && $bisestile) {
    $giorni = 29;
}

if ($stmt instanceof PDOStatement) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nome_farmaco = (string) ($row['principio'] ?? '');
        $cprBox = (int) ($row['cpr_box'] ?? 1);
        if ($cprBox <= 0) {
            $cprBox = 1;
        }

        $rsa->table = 'pazienti_farmaci';
        $rsa->id_farmaci = (int) ($row['id'] ?? 0);

        $stmt1 = $rsa->showAllWhere('id', ['id_farmaci']);
        $pazienti = [];
        $scatole_tot = 0;

        if ($stmt1 instanceof PDOStatement) {
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $cprGiorno = (float) ($row1['cpr'] ?? 0);
                $cprMese = $cprGiorno * $giorni;
                $magazzino = (int) ($row1['magazzino'] ?? 0);

                $scatole = (int) ceil($cprMese / $cprBox);
                $scatole_mag = $scatole - $magazzino;

                if ($scatole_mag > 0) {
                    $scatole_tot += $scatole_mag;

                    $rsa->table = 'pazienti';
                    $rsa->id = (int) ($row1['id_pazienti'] ?? 0);
                    $stmt2 = $rsa->showAllWhere('id', ['id']);
                    $row2 = $stmt2 ? $stmt2->fetch(PDO::FETCH_ASSOC) : null;
                    if ($row2) {
                        $pazienti[] = trim(($row2['cognome'] ?? '') . ' ' . ($row2['nome'] ?? ''));
                    }
                }
            }
        }

        $cpr_mese_tot_ordinare = $scatole_tot * $cprBox;

        if ($scatole_tot > 0) {
            $ordine[] = [
                'farmaco' => $nome_farmaco,
                'compresse' => $cpr_mese_tot_ordinare,
                'scatole' => $scatole_tot,
                'pazienti' => $pazienti,
            ];
        }
    }
}

$folder = '../inc/ordini';
if (!is_dir($folder)) {
    @mkdir($folder, 0755, true);
}

$file = "{$folder}/ordine.json";
if (file_exists($file)) {
    @unlink($file);
}

$json = json_encode($ordine, JSON_PRETTY_PRINT);

if (file_put_contents($file, (string) $json)) {
    header("Location: ../index.php?p=allOrdini&msg=ordiniAddSucc&mese={$mese}");
    exit;
}

header('Location: ../index.php?p=addOrdini&err=ordiniFail');
exit;