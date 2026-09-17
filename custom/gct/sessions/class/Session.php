<?php

declare(strict_types=1);

##############    Damares    ###############
#                                          #
#    A backend project by DM WebLab        #
#   Website: https://www.dmweblab.com      #
#   GitHub: https://github.com/damares86   #
#                                          #
############################################

class Session extends Common
{
    public string $table = 'sessions';
    public ?string $name = null;
    public ?string $avatar = 'default.png';
    public ?string $description = null;
    public ?string $details = null;
    public ?string $details_opt = null;
    public ?string $sessions_name = null;
    public ?string $date = null;
    public ?string $start_time = null;
    public ?string $end_time = null;
    public int|string|null $location = null;
    public int|string|null $session_id = null;
    public int|string|null $speaker_id = null;
    public int|string|null $speaker_doc_id = null;
    public ?string $speakers_doc_name = null;
    public ?string $inputFileName = null;
    public ?string $path = null;
    public ?string $origin = null;
    public ?string $label = null;
    public int|string|null $active = 0;
    public int|string|null $question_active = 0;
    public ?string $people_name = null;
    public ?string $people_cat = null;
    public int|string|null $cat_id = null;
    public int|string|null $people_id = null;
    public ?string $location_name = null;
    public int|string|null $location_id = null;
    public ?string $relations_id = null;

    /**
     * Upload speaker document.
     *
     * @return bool
     */
    public function uploadFile(): bool
    {
        if (empty($this->speakers_doc_name) || empty($this->path) || empty($this->inputFileName)) {
            return false;
        }

        $targetDirectory = rtrim($this->path, '/\\') . DIRECTORY_SEPARATOR;
        $targetFile = $targetDirectory . basename($this->speakers_doc_name);
        $fileType = strtolower((string) pathinfo($targetFile, PATHINFO_EXTENSION));

        if ($fileType !== 'pdf') {
            $origin = !empty($this->origin) ? $this->origin : 'allPeople';
            header("Location: ../index.php?p={$origin}&idToMod={$this->id}&err=formatErr");
            exit;
        }

        if (!is_dir($targetDirectory)) {
            @mkdir($targetDirectory, 0755, true);
        }

        if (is_uploaded_file($this->inputFileName) && move_uploaded_file($this->inputFileName, $targetFile)) {
            @chmod($targetFile, 0644);

            $query = "INSERT INTO {$this->prx}{$this->table} (speakers_doc_name, label, speaker_id) VALUES (:speakers_doc_name, :label, :speaker_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':speakers_doc_name', $this->speakers_doc_name);
            $stmt->bindValue(':label', $this->label);
            $stmt->bindValue(':speaker_id', $this->speaker_id);

            return $stmt->execute();
        }

        return false;
    }
}