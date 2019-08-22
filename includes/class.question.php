<?php

Class Question {
    /**
     * @description Creates a new question using the data provided
     * @access public
     *
     * @param array $data question data
     *
     * @return boolean
     */
    public function create($data = []) {
        global $mysql;

        if ($query = $mysql->prepare("INSERT INTO `questions` SET `name` = ?, `questions_categories_id` = ?, `question` = ?, `active` = ?")) {
            if ($query->bind_param("sisi", $data['name'], $data['questions_categories_id'], $data['question'], $data['active'])) {
                if ($query->execute()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @description Updates an existing question with the data provided
     * @access public
     *
     * @param integer $id unique id of the question
     * @param array $data questions data
     *
     * @return boolean
     */
    public function update($id = null, $data = []) {
        global $mysql;

        if ($query = $mysql->prepare("UPDATE `questions` SET `name` = ?, `questions_categories_id` = ?, `question` = ?, `active` = ? WHERE `id` = ?")) {
            if ($query->bind_param("sisii", $data['name'], $data['questions_categories_id'], $data['question'], $data['active'], $id)) {
                if ($query->execute()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @description Deletes an existing question from the database
     * @access public
     *
     * @param integer $id unique id of the question
     *
     * @return boolean
     */
    public function delete($id = null) {
        global $mysql;

        if ($query = $mysql->prepare("SELECT COUNT(*) AS total FROM `interviews_answers` WHERE `question_id` = ?")) {
            if ($query->bind_param("i", $id)) {
                if ($query->execute()) {
                    $result = $query->get_result();

                    if ($result->fetch_assoc()['total'] === 0) {
                        if ($query = $mysql->prepare("DELETE FROM `questions` WHERE `id` = ?")) {
                            if ($query->bind_param("i", $id)) {
                                if ($query->execute()) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * @description Returns the data of the question requested
     * @access public
     *
     * @param integer $id unique id of the question
     *
     * @return array | boolean
     */
    public function read($id = null) {
        global $mysql;

        if ($query = $mysql->prepare("SELECT * FROM questions WHERE id = ?")) {
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
}