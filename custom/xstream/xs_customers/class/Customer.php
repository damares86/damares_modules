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
    public ?string $username = null;
    public ?string $email = null;
    public ?string $company = null;
    public ?string $password = null;
    public ?string $details = null;
    public ?string $details_opt = null;
    public ?string $auth_token = 'none';
    public ?string $last_login = null;

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

        $query = "SELECT id FROM {$this->prx}{$this->table} WHERE username = :username AND email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':username', $this->username);
        $stmt->bindValue(':email', $this->email);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Verify cookie token authentication.
     *
     * @return int
     */
    public function checkCookie(): int
    {
        if ($this->conn === null) {
            return 0;
        }

        $query = "SELECT id FROM {$this->prx}{$this->table} WHERE id = :id AND auth_token = :auth_token LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $this->id);
        $stmt->bindValue(':auth_token', $this->auth_token);
        $stmt->execute();

        return $stmt->rowCount();
    }
}