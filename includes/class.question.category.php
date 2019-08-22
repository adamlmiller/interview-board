<?php

Class QuestionCategory {
    /**
     * @description Creates a new question category using the data provided
     * @access public
     *
     * @param array $data question category data
     *
     * @return boolean
     */
    public function create($data = []) {
        global $mysql;

        if ($query = $mysql->prepare("INSERT INTO `questions_categories` SET `name` = ?, `description` = ?, `active` = ?")) {
            if ($query->bind_param("ssi", $data['name'], $data['description'], $data['active'])) {
                if ($query->execute()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @description Updates an existing question category with the data provided
     * @access public
     *
     * @param integer $id unique id of the question category
     * @param array $data question cateogories data
     *
     * @return boolean
     */
    public function update($id = null, $data = []) {
        global $mysql;

        if ($query = $mysql->prepare("UPDATE `questions_categories` SET `name` = ?, `description` = ?, `active` = ? WHERE `id` = ?")) {
            if ($query->bind_param("ssii", $data['name'], $data['description'], $data['active'], $id)) {
                if ($query->execute()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @description Deletes an existing question category from the database
     * @access public
     *
     * @param integer $id unique id of the question category
     *
     * @return boolean
     */
    public function delete($id = null) {
        global $mysql;

        if ($this->read($id)) {
            if ($query = $mysql->prepare("DELETE FROM `questions_categories` WHERE `id` = ?")) {
                if ($query->bind_param("i", $_POST['id'])) {
                    if ($query->execute()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @description Returns the data of the question category requested
     * @access public
     *
     * @param integer $id unique id of the question category
     *
     * @return array | boolean
     */
    public function read($id = null) {
        global $mysql;

        if ($query = $mysql->prepare("SELECT * FROM questions_categories WHERE id = ?")) {
            if ($query->bind_param("i", $id)) {
                if ($query->execute()) {
                    if ($result = $query->get_result()) {
                        return $result->fetch_assoc();
                    }
                }
            }
        }

        return false;
    }
}