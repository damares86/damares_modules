<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Newsletter extends Common
{
    public string $table = 'newsletter_subscribers';
    public ?string $subscriber = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $subject = null;
    public ?string $body = null;
    public ?string $subscribed_at = null;
    public int|string|null $confirmed = 1;
    public int|string|null $status = 0;
    public int|string|null $message_id = null;
    public ?string $subscriber_email = null;
    public int|string|null $subscriber_id = null;
}