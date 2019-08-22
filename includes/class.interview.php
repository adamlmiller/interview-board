<?php

Class Interview {
    /**
     * @description Creates a new interview using the data provided
     * @access public
     *
     * @param array $data interview data
     *
     * @return boolean
     */
    public function create($data = []) {
        global $mysql;

        if ($query = $mysql->prepare("INSERT INTO `interviews` SET `user_id` = ?, `first_name` = ?, `last_name` = ?, `email` = ?, `phone` = ?, `date` = ?, `method` = ?, `qa` = ?, `notes` = ?, `hire` = ?")) {
            if ($query->bind_param("isssssssss", $_SESSION['user']['id'], $data['first_name'], $data['last_name'], $data['email'], $data['phone'], $data['date'], $data['method'], $data['qa'], $data['notes'], $data['hire'])) {
                if ($query->execute()) {
                    $interview_id = $query->insert_id;

                    foreach ($data['answer'] AS $key => $value) {
                        $answer = $mysql->prepare("INSERT INTO `interviews_answers` SET `interview_id` = ?, `question_id` = ?, `answer` = ?");
                        $answer->bind_param("iis", $interview_id, $key, $value);
                        $answer->execute();
                    }

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @description Updates an existing interview with the data provided
     * @access public
     *
     * @param integer $id unique id of the interview
     * @param array $data interviews data
     *
     * @return boolean
     */
    public function update($id = null, $data = []) {
        global $mysql;

        if ($query = $mysql->prepare("UPDATE `interviews` SET `first_name` = ?, `last_name` = ?, `email` = ?, `phone` = ?, `date` = ?, `method` = ?, `qa` = ?, `notes` = ?, `hire` = ? WHERE id = ?")) {
            if ($query->bind_param("sssssssssi", $data['first_name'], $data['last_name'], $data['email'], $data['phone'], $data['date'], $data['method'], $data['qa'], $data['notes'], $data['hire'], $id)) {
                if ($query->execute()) {
                    $query = $mysql->prepare("DELETE FROM `interviews_answers` WHERE `interview_id` = ?");
                    $query->bind_param("i", $id);
                    $query->execute();

                    foreach ($data['answer'] AS $key => $value) {
                        $answer = $mysql->prepare("INSERT INTO `interviews_answers` SET `interview_id` = ?, `question_id` = ?, `answer` = ?");
                        $answer->bind_param("iis", $id, $key, $value);
                        $answer->execute();
                    }

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @description Deletes an existing interview from the database
     * @access public
     *
     * @param integer $id unique id of the user
     *
     * @return boolean
     */
    public function delete($id = null) {
        global $mysql;
    }

    /**
     * @description Returns the data of the interview requested
     * @access public
     *
     * @param integer $id unique id of the interview
     *
     * @return array | boolean
     */
    public function read($id = null) {
        global $mysql;

        if ($query = $mysql->prepare("SELECT * FROM interviews WHERE id = ?")) {
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