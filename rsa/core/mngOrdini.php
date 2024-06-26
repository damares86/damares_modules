<?php


##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################


require __DIR__."/coreConfig.php";

$rsa->table = 'farmaci' ;
$stmt = $rsa->showAll('id') ;

$ordine = [] ;

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
    '12' => 31
];

$mese = filter_input(INPUT_POST,'mese');
$giorni = $array_month[$mese] ;

$anno = date('Y');
$bisestile = $rsa->is_leap_year($anno);
if($mese=='02' && $bisestile )
{
    $giorni = 29 ;
}

while( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
{

    extract($row);

    $nome_farmaco = $row['principio'] ;
    echo "Farmaco: $nome_farmaco <br>";

    $rsa->table = 'pazientiFarmaci' ;
    $rsa->id_farmaci = $row['id'] ;

    
    $stmt1 = $rsa->showAllWhere('id',['id_farmaci']) ;
    
    $pazienti = [] ;
    $cpr_mese = 0 ;
    $scatole_tot = 0 ;
    $cpr_mese_tot = 0 ;
    $cpr_mese_tot_ordinare = 0 ;
    
    while( $row1 = $stmt1->fetch(PDO::FETCH_ASSOC) )
    {
        $scatole_mag = 0 ;
        $cpr_giorno = 0 ;
        $cpr_mag = 0 ;
        $cpr_ordine = 0 ;

        extract($row1);
        echo "---------------------<br>";
        echo 'id paziente '.$row1['id_pazienti'].'<br>';
        echo 'id farmaco '.$row1['id_farmaci'].'<br>';
        // compresse al giorno del singolo farmaco
        $cpr_giorno += $row1['cpr'] ;
        echo 'cpr_giorno '.$cpr_giorno.'<br>';
        
        // sommo alle compresse al mese del singolo farmaco, contando quelle di ogni singolo paziente (ogni ciclo)
        $cpr_mese = $cpr_giorno * $giorni ;
        $cpr_mese_tot += $cpr_mese ;
        echo 'cpr_mese '.$cpr_mese.'<br>';
        echo 'cpr_mese_tot '.$cpr_mese_tot.'<br>';
        
        // conto quante scatole servono al paziente
        $scatole = ceil($cpr_mese/$row['cpr_box'] ) ;
        echo 'scatole '.$scatole.'<br>';
        echo 'magazzino '.$row1['magazzino'].'<br>';
        
        // sottraggo le scatole della stanza
        $scatole_mag = $scatole - $row1['magazzino'] ;
        echo 'scatole necessarie '.$scatole_mag.'<br>';
        
        if($scatole_mag>0)
        {

            $cpr_mag = $row1['magazzino']*$row['cpr_box'];
            echo "cpr_mag: $cpr_mag<br>";
            
            $cpr_ordine = $cpr_mese_tot - $cpr_mag ;
            echo "cpr_ordine: $cpr_ordine<br>";


            $scatole_tot += $scatole_mag ;
            
            $rsa->table = 'pazienti' ;
            $rsa->id = $row1['id_pazienti'] ;
            $stmt2 = $rsa->showAllWhere('id',['id']) ;
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC) ;
            extract($row2) ;
            
            $pazienti[] = ''.$row2['cognome'].' '.$row2['nome'].'' ;
        }
        echo 'scatole_tot '.$scatole_tot.'<br>';
    }
    
    echo "---------------------<br>";
    $cpr_mese_tot_ordinare += $scatole_tot*$row['cpr_box'];
    
    
    
    if($scatole_tot>0)
    {
        $ordine[] = array( 'farmaco' => $nome_farmaco, 'compresse'=> $cpr_mese_tot_ordinare, 'scatole' => $scatole_tot, 'pazienti' =>$pazienti) ;
    }
    print_r($ordine) ; 
    echo "---------------------<br>";

}

$folder = '../inc/ordini';
if(!is_dir($folder)){
    $oldmask = umask(0);
    mkdir($folder, 0777, true);
    umask($oldmask);
}else{
    $oldmask = umask(0);
    chmod($folder, 0777);
    umask($oldmask);
}

$file = "$folder/ordine.json" ;

unlink($file);

$json=json_encode($ordine);

if(file_put_contents($file, $json, FILE_APPEND))
{
    header("Location: ../index.php?p=allOrdini&msg=ordiniAddSucc&mese=$mese");
    exit;
}
else
{
    header("Location: ../index.php?p=addOrdini&err=ordiniFail");
    exit;
}