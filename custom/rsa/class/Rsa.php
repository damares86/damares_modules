<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Rsa extends Common
{
    public string $table = 'pazienti';

    // Farmaci
    public ?string $principio = null;
    public int|string|null $cpr_box = null;
    public int|string|null $magazzino = 0;

    // Pazienti
    public ?string $cognome = null;
    public ?string $nome = null;

    // Pazienti Farmaci (table pazienti_farmaci)
    public int|string|null $id_pazienti = null;
    public int|string|null $id_farmaci = null;
    public float|string|null $cpr = null;

    /**
     * Check if a year is a leap year.
     *
     * @param int $year
     * @return bool
     */
    public function is_leap_year(int $year): bool
    {
        if ($year % 400 === 0) {
            return true;
        }
        if ($year % 100 === 0) {
            return false;
        }
        return $year % 4 === 0;
    }
}