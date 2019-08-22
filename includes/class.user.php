<?php

Class User {
    /**
     * @description Creates a new user using the data provided
     * @access public
     *
     * @param array $data users data
     *
     * @return boolean
     */
    public function create($data = []) {
        global $mysql;

        if ($query = $mysql->prepare("INSERT INTO `users` SET `first_name` = ?, `last_name` = ?, `phone` = ?, `email` = ?, `password` = ?, `active` = ?")) {
            if ($query->bind_param("sssssi", $data['first_name'], $data['last_name'], $data['phone'], $data['email'], $data['password'], $data['active'])) {
                if ($query->execute()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @description Updates an existing user with the data provided
     * @access public
     *
     * @param integer $id unique id of the user
     * @param array $data users data
     *
     * @return boolean
     */
    public function update($id = null, $data = []) {
        global $mysql;

        if (!empty($data['password'])) {
            $this->password($id, $data['password']);
        }

        if ($query = $mysql->prepare("UPDATE `users` SET `first_name` = ?, `last_name` = ?, `phone` = ?, `email` = ?, `active` = ? WHERE `id` = ?")) {
            if ($query->bind_param("ssssii", $data['first_name'], $data['last_name'], $data['phone'], $data['email'], $data['active'], $id)) {
                if ($query->execute()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @description Deletes an existing user from the database
     * @access public
     *
     * @param integer $id unique id of the user
     *
     * @return boolean
     */
    public function delete($id = null) {
        global $mysql;

        if ($this->read($id)) {
            if ($query = $mysql->prepare("DELETE FROM `users` WHERE `id` = ?")) {
                if ($query->bind_param("i", $id)) {
                    if ($query->execute()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @description Returns the data of the user requested
     * @access public
     *
     * @param integer $id unique id of the user
     *
     * @return array | boolean
     */
    public function read($id = null) {
        global $mysql;

        if ($query = $mysql->prepare("SELECT * FROM users WHERE id = ?")) {
            if ($query->bind_param("i", $id)) {
                if ($query->execute()) {
                    if ($result = $query->get_result()) {
                        if ($result->num_rows === 1) {
                            return $result->fetch_assoc();
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * @description Update the users password
     * @access public
     *
     * @param integer $id unique id of the user
     * @param string $password users new password
     *
     * @return boolean
     */
    public function password($id = null, $password = null) {
        global $mysql;

        $password = password_hash($password, PASSWORD_BCRYPT);

        if ($query = $mysql->prepare("UPDATE `users` SET `password` = ? WHERE `id` = ?")) {
            if ($query->bind_param("si", $password, $id)) {
                if ($query->execute()) {
                    return true;
                }
            }
        }

        return false;
    }
}