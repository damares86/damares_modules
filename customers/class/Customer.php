<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Customer extends Common
{
    public string $table = 'customers';
    public int|string|null $id = null;
    public ?string $name = null;
    public ?string $surname = null;
    public ?string $details = null;
    public ?string $details_opt = null;

    /**
     * Check if a customer already exists.
     *
     * @return bool
     */
    public function customerExists(): bool
    {
        if ($this->conn === null) {
            return false;
        }

        $query = "SELECT id FROM {$this->prx}{$this->table} WHERE `name` = :name AND `surname` = :surname LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':surname', $this->surname);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }
}