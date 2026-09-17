<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Rate extends Common
{
    public string $table = 'rate';
    public ?string $cat_name = null;
    public int|string|null $active = 0;
    public int|string|null $rate_cat_id = null;
    public int|string|null $item_id = null;
    public int|string|null $rate_active = 0;
    public int|string|null $item_rate_id = null;
    public int|string|null $vote_sum = 0;
    public int|string|null $vote_number = 0;
    public ?string $star = null;
    public float|string|null $star_vote = 0.0;
    public int|string|null $percent = 0;
}