<?php

Class InterviewAnswer {
    /**
     * @description Returns the answers for an interview
     * @access public
     *
     * @param integer $interivew_id unique id of the interview
     *
     * @return array | boolean
     */
    public function get($interview_id = null) {
        global $mysql;

        if ($query = $mysql->prepare("SELECT * FROM interviews_answers ia, questions q WHERE q.id = ia.question_id AND interview_id = ?")) {
            if ($query->bind_param("i", $interview_id)) {
                if ($query->execute()) {
                    if ($result = $query->get_result()) {
                        if ($result->num_rows >= 1) {
                            $answers = [];

                            while ($answer = $result->fetch_assoc()) {
                                $answers[] = [
                                    'question_id' => $answer['question_id'],
                                    'question' => $answer['question'],
                                    'answer' => $answer['answer']
                                ];
                            }

                            return $answers;
                        }
                    }
                }
            }
        }

        return false;
    }
}