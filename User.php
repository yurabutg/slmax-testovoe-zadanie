<?php

class User
{
    public $id;
    public $first_name;
    public $last_name;
    public $birth_date;
    public $gender;
    public $birth_city;

    protected Database $db;

    /**
     * Constructor for creating a new User or fetching existing User information.
     *
     * @param int|null $id
     *   The User ID. If null, a new User will be created.
     * @param string|null $first_name
     * @param string|null $last_name
     * @param string|null $birth_date
     * @param int|null $gender
     * @param string|null $birth_city
     * @throws Exception
     */
    public function __construct(int $id = null, string $first_name = null, string $last_name = null, string $birth_date = null, int $gender = null, string $birth_city = null)
    {

        if (!class_exists('Database')) {
            die('Database class is not found.');
        }
        // DB connection
        $this->db = new Database();

        // Check if the User exist
        if (!is_null($id)) {
            $user = $this->getById($id);
            if (empty($user)) {
                die('User non exist');
            }
            $this->id = $user['id'];
        }

        // Set the User's data
        $this->first_name = (!isset($user)) ? $first_name : $user['first_name'] ?? null;
        $this->last_name = (!isset($user)) ? $last_name : $user['last_name'] ?? null;
        $this->birth_date = (!isset($user)) ? $birth_date : $user['birth_date'] ?? null;
        $this->gender = (!isset($user)) ? $gender : $user['gender'] ?? null;
        $this->birth_city = (!isset($user)) ? $birth_city : $user['birth_city'] ?? null;

        // Save New User
        if (!isset($user)) $this->saveUser();
    }

    /**
     * @param $id
     * @return array
     */
    public function getById($id): array
    {
        return $this->db->getById($id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete(): bool
    {
        return $this->db->deleteById($this->id);
    }

    /**
     * @param $user
     * @param bool $full_age
     * @param bool $gender
     * @return stdClass
     * @throws Exception
     */
    public function formatUser($user, bool $full_age = false, bool $gender = false): stdClass
    {
        $formatted = new stdClass();
        $formatted->first_name = $user->first_name;
        $formatted->last_name = $user->last_name;
        $formatted->birth_date = ($full_age) ? self::getFullAge($user->birth_date) : $user->birth_date;
        $formatted->gender = $gender ? self::getGenderString($user->gender) : $user->gender;
        $formatted->birth_city = $user->birth_city;
        return $formatted;
    }

    /**
     * @param $birth_date
     * format: 'Y-m-d'
     * @return int
     * @throws Exception
     */
    public static function getFullAge($birth_date): int
    {
        $birth_date = new DateTime($birth_date);
        return $birth_date->diff(new DateTime(date('Y-m-d')))->y;
    }

    /**
     * @param int $gender
     * 0|1
     * @return string
     */
    public static function getGenderString(int $gender): string
    {
        return match ($gender) {
            0 => 'male',
            1 => 'female',
            default => '',
        };
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @param string $birth_date
     */
    public function setBirthDate(string $birth_date): void
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @param string $birth_city
     */
    public function setBirthCity(string $birth_city): void
    {
        $this->birth_city = $birth_city;
    }

    public function saveUser(): void
    {
        // Validate data
        $validate = $this->_validateData();
        if ($validate !== true) {
            die("Invalid {$validate}");
        }

        if (!is_null($this->id)) $user['id'] = $this->id;
        if (!is_null($this->first_name)) $user['first_name'] = $this->first_name;
        if (!is_null($this->last_name)) $user['last_name'] = $this->last_name;
        if (!is_null($this->birth_date)) $user['birth_date'] = date('Y-m-d', strtotime($this->birth_date));
        if (!is_null($this->gender)) $user['gender'] = $this->gender;
        if (!is_null($this->birth_city)) $user['birth_city'] = $this->birth_city;

        $this->db->saveUser($user);
    }

    private function _validateData(): bool|string
    {
        if (!is_null($this->first_name) && !$this->_charsOnly($this->first_name)) return 'first_name';
        if (!is_null($this->last_name) && !$this->_charsOnly($this->last_name)) return 'last_name';
        if (!is_null($this->gender) && !in_array($this->gender, [0, 1])) return 'gender';
        if (!is_null($this->birth_date) && !DateTime::createFromFormat("Y-m-d", $this->birth_date)) return 'birth_date';
        return true;
    }

    private function _charsOnly(string $string): bool
    {
        return (ctype_alpha($string));
    }
}