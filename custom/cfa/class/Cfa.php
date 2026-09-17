<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Cfa extends Common
{
    public string $table = 'polizze';

    // Collaboratore
    public ?string $nome = null;
    public ?string $cognome = null;
    public ?string $sede_legale = null;
    public ?string $sede_operativa = null;
    public ?string $telefono = null;
    public ?string $cellulare = null;
    public ?string $email = null;
    public ?string $pec = null;
    public ?string $codice_fiscale = null;
    public ?string $p_iva = null;
    public int|string|null $ritenuta_acconto = 0;
    public ?string $iban = null;
    public ?string $banca = null;
    public ?string $iscrizione_rui = null;
    public int|float|string|null $provvigioni_dare = null;
    public int|float|string|null $provvigioni_avere = null;
    public int|float|string|null $consulenza_collab = null;
    public int|float|string|null $premio_collab = null;

    // Compagnie
    public int|float|string|null $provv = null;
    public int|string|null $provv_calcolate_su = 0;

    // Contraente
    public ?string $nome_contraente = null;
    public ?string $cognome_contraente = null;
    public ?string $ragione_sociale_contraente = null;
    public ?string $via_contraente = null;
    public ?string $citta_contraente = null;
    public ?string $cap_contraente = null;
    public ?string $codice_fiscale_contraente = null;
    public ?string $p_iva_contraente = null;
    public ?string $telefono_contraente = null;
    public ?string $cellulare_contraente = null;
    public ?string $email_contraente = null;

    // Beneficiario
    public ?string $ragione_sociale_beneficiario = null;
    public ?string $via_beneficiario = null;
    public ?string $citta_beneficiario = null;
    public ?string $cap_beneficiario = null;
    public ?string $codice_fiscale_beneficiario = null;
    public ?string $p_iva_beneficiario = null;

    // Polizze
    public int|float|string|null $da_pagare = 0;
    public int|string|null $id_collaboratore = null;
    public int|string|null $id_compagnia = null;
    public int|float|string|null $netto = 0;
    public int|float|string|null $diritti = 0;
    public int|float|string|null $imponibile = 0;
    public int|float|string|null $lordo = 0;
    public int|float|string|null $spese = 0;
    public int|float|string|null $imposte = 0;
    public int|string|null $numero = null;
    public ?string $tipologia = null;
    public int|string|null $id_contraente = null;
    public int|string|null $id_beneficiario = null;
    public ?string $descrizione = null;
    public int|float|string|null $importo_gara = null;
    public int|float|string|null $massimale = null;
    public ?string $st = null;
    public ?string $et = null;
    public int|string|null $id_calendar_cat = null;
    public int|float|string|null $consulenza = null;
    public ?string $incasso_data = null;
    public ?string $incasso_mod = null;
    public int|float|string|null $pagato_da_compagnia = 0;
    public int|string|null $compagnia_pagato = 0;
    public int|float|string|null $pagato_da_collaboratore = 0;
    public int|string|null $collaboratore_pagato = 0;
    public int|string|null $copia_direzione = 0;
}