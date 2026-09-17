<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Story extends Common
{
    public string $table = 'story';
    public ?string $title = null;
    public ?string $description = null;
    public int|string|null $num = 1;
    public ?string $content = null;
    public int|string|null $story_id = null;
    public int|string|null $completed = 0;
}