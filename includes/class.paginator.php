<?php

/*
 * https://code.tutsplus.com/tutorials/how-to-paginate-data-with-php--net-2928
 */

class Paginator {
    private $_conn;
    private $_limit;
    private $_page;
    private $_query;
    private $_total;

    public function __construct($conn, $query) {
        $this->_conn = $conn;
        $this->_query = $query;
        $result = $this->_conn->query($this->_query);
        $this->_total = $result->num_rows;
    }

    public function fetch($limit = 10, $page = 1) {
        $data = [];
        $this->_limit = $limit;
        $this->_page = $page;

        if ($this->_limit == 'all') {
            $query = $this->_query;
        } else {
            $query = $this->_query . " LIMIT " . (($this->_page - 1) * $this->_limit) . ", $this->_limit";
        }

        $results = $this->_conn->query($query);

        while ($row = $results->fetch_assoc()) {
            $data[] = $row;
        }

        $result = new stdClass();
        $result->page = $this->_page;
        $result->limit = $this->_limit;
        $result->total = $this->_total;
        $result->data = $data;

        return $result;
    }

    public function links($links) {
        if ($this->_limit == 'all') { return ''; }

        $from = (($this->_page * $this->_limit) - $this->_limit + 1);
        $to = min(($this->_page * $this->_limit), $this->_total);

        $html = '<div class="row">';
        $html .= '<div class="col-6">';

        if ($to > 0) {
            $html .= '<div class="pagination-showing">Showing ' . $from . ' to ' . $to . ' of ' . $this->_total . '</div>';
        }

        $html .= '</div>';
        $html .= '<div class="col-6">';

        $last = ceil($this->_total / $this->_limit);
        $start = (($this->_page - $links) > 0) ? $this->_page - $links : 1;
        $end = (($this->_page + $links) < $last) ? $this->_page + $links : $last;

        $html .= '<ul class="pagination justify-content-end">';

        $class = ($this->_page == 1) ? "disabled" : "";

        $html .= '<li class="page-item ' . $class . '"><a class="page-link" href="?limit=' . $this->_limit . '&page=' . ($this->_page - 1) . '">&laquo;</a></li>';

        if ($start > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="?limit=' . $this->_limit . '&page=1">1</a></li>';
            $html .= '<li class="page-item disabled"><span>...</span></li>';
        }

        if ($end > 1) {
            for ($i = $start; $i <= $end; $i++) {
                $class = ($this->_page == $i) ? "active" : "";
                $html .= '<li class="page-item ' . $class . '"><a class="page-link" href="?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
            }
        }

        if ($end < $last) {
            $html .= '<li class="page-item disabled"><span>...</span></li>';
            $html .= '<li><a class="page-link" href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
        }

        $class = ($this->_page == $last) ? "disabled" : "";
        $html .= '<li class="page-item ' . $class . '"><a class="page-link" href="?limit=' . $this->_limit . '&page=' . ($this->_page + 1) . '">&raquo;</a></li>';
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
}