<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Post extends Common
{
    public string $table = 'post';
    public ?string $title = null;
    public ?string $content = null;
    public ?int $limit = null;
    public int|string|null $author = null;
    public ?string $created = null;
    public ?string $modified = null;
    public ?string $main_img = null;
    public ?string $gall = null;
    public int|string|null $category_id = null;
    public ?string $category_name = null;
    public ?string $post_link = null;
    public int|string|null $assign_page = null;
    public ?string $more = 'Read more';

    /**
     * Generate a truncated excerpt with a read more link.
     *
     * @return string
     */
    public function readMore(): string
    {
        if ($this->content === null) {
            return '';
        }

        $limit = $this->limit ?? 200;
        $cleanContent = strip_tags($this->content);

        if (mb_strlen($cleanContent) <= $limit) {
            return $cleanContent;
        }

        $truncated = mb_substr($cleanContent, 0, $limit);
        $lastSpace = mb_strrpos($truncated, ' ');
        if ($lastSpace !== false) {
            $truncated = mb_substr($truncated, 0, $lastSpace);
        }

        $link = htmlspecialchars((string) ($this->post_link ?? '#'), ENT_QUOTES, 'UTF-8');
        $moreText = htmlspecialchars((string) ($this->more ?? 'Read more'), ENT_QUOTES, 'UTF-8');

        return $truncated . "... <a href=\"{$link}\">{$moreText}</a>";
    }
}