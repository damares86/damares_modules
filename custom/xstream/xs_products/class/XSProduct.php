<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class XSProduct extends Common
{
    public string $table = 'product';
    public ?string $product_name = null;
    public ?string $old_product_name = null;
    public ?string $product_files_name = null;
    public ?string $product_files_label = null;
    public int|string|null $product_files_cat_id = null;
    public int|string|null $product_id = null;
    public ?string $permissions = null;
    public int|string|null $customers_id = null;
    public ?string $cat_name = null;
    public ?string $old_cat_name = null;
}