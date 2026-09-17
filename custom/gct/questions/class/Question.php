<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Question extends Common
{
    public string $table = 'questions';
    public int|string|null $relation_id = null;
    public int|string|null $session_id = null;
    public int|string|null $account_id = null;
    public ?string $question = null;
    public int|string|null $approved = 0;
}