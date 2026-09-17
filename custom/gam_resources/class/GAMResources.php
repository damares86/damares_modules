<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class GAMResources extends Common
{
    public string $table = 'resources';
    public ?string $resource_name = null;
    public ?string $title = null;
    public ?string $description = null;
    public int|string|null $cat_id = null;
    public int|string|null $type_id = null;
    public ?string $img = 'default_res.png';
    public ?string $resource_date = null;
    public ?string $cat = null;
    public ?string $type = null;
}