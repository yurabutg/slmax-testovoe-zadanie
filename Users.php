<?php

class Users
{
    public $users_ids = [];

    protected Database $db;

    /**
     * @param $condition
     * $condition is the comparison operator to use in the search. For example, you could use =, <, >, <=, >=, LIKE, etc.
     */
    public function __construct($field, $condition, $value)
    {
        if (!class_exists('User')) {
            die('User class is not found.');
        }

        if (!class_exists('Database')) {
            die('Database class is not found.');
        }
        // DB connection
        $this->db = new Database();

        $this->users_ids = $this->_searchUsers($field, $condition, $value);
    }

    /**
     * @throws Exception
     */
    public function getUsersList(): array
    {
        if (empty($this->users_ids)) return [];

        $results = [];
        foreach ($this->users_ids as $id) {
            $results[] = new User($id);
        }
        return $results;
    }

    public function deleteUsers(){
        if (empty($this->users_ids)) return false;

        foreach ($this->users_ids as $id) {
            $user = new User($id);
            if (!$user->delete()) return false;
        }
        return true;
    }

    private function _searchUsers($field, $condition, $value): array
    {
        return $this->db->getUsersIdsByConditions($field, $condition, $value);
    }
}