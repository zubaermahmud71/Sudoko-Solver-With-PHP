<?php 
set_time_limit(300);


if (isset($_POST['array'])) {
    
    $data = $_POST['array'];
    $data_str = '';
    $counter = 1;
    foreach ($data as $key) {
        if ($key['value']) {
            $i = $key['value'];
        }else {
            $i = 0;
        }
        if ($counter == 81) {
            $data_str = $data_str . $i;
        }else {
            $data_str = $data_str . $i . '-';
        }        
        $counter = $counter + 1;
    }
    $data = explode('-', $data_str);


    class Sudoku {

        private $comming_arr = array();
        private $grids = array();
        private $columns_begining = array();
        private $time_tracking = array();
    
        public function __construct() {
            $this->time_tracking['start'] = microtime(true);
        }
    
        private function set_grids() { //MAKE GRIDS
            $grids = array();
            foreach ($this->comming_arr as $k => $row) {
                if ($k <= 2) {
                    $row_num = 1;
                }
                if ($k > 2 && $k <= 5) {
                    $row_num = 2;
                }
                if ($k > 5 && $k <= 8) {
                    $row_num = 3;
                }
    
                foreach ($row as $kk => $r) {
                    if ($kk <= 2) {
                        $col_num = 1;
                    }
                    if ($kk > 2 && $kk <= 5) {
                        $col_num = 2;
                    }
                    if ($kk > 5 && $kk <= 8) {
                        $col_num = 3;
                    }
                    $grids[$row_num][$col_num][] = $r;
                }
            }
            $this->grids = $grids;
        }
    
        private function set_columns() { //ORDER BY COLUMNS
            $columns_begining = array();
            $i = 1;
            foreach ($this->comming_arr as $k => $row) {
                $e = 1;
                foreach ($row as $kk => $r) {
                    $columns_begining[$e][$i] = $r;
                    $e++;
                }
                $i++;
            }
            $this->columns_begining = $columns_begining;
        }
    
        private function get_possibilities($k, $kk) { //GET POSSIBILITIES FOR GIVEN CELL
            $values = array();
            if ($k <= 2) {
                $row_num = 1;
            }
            if ($k > 2 && $k <= 5) {
                $row_num = 2;
            }
            if ($k > 5 && $k <= 8) {
                $row_num = 3;
            }
    
            if ($kk <= 2) {
                $col_num = 1;
            }
            if ($kk > 2 && $kk <= 5) {
                $col_num = 2;
            }
            if ($kk > 5 && $kk <= 8) {
                $col_num = 3;
            }
    
            for ($n = 1; $n <= 9; $n++) {
                if (!in_array($n, $this->comming_arr[$k]) && !in_array($n, $this->columns_begining[$kk + 1]) && !in_array($n, $this->grids[$row_num][$col_num])) {
                    $values[] = $n;
                }
            }
            shuffle($values);
            return $values;
        }
    
        public function solve_it($arr) {
            while (true) {
                $this->comming_arr = $arr;
    
                $this->set_columns();
                $this->set_grids();
    
                $ops = array();
                foreach ($arr as $k => $row) {
                    foreach ($row as $kk => $r) {
                        if ($r == 0) {
                            $pos_vals = $this->get_possibilities($k, $kk);
                            $ops[] = array(
                                'rowIndex' => $k,
                                'columnIndex' => $kk,
                                'permissible' => $pos_vals
                            );
                        }
                    }
                }
    
                if (empty($ops)) {
                    return $arr;
                }
    
                usort($ops, array($this, 'sortOps'));
    
                if (count($ops[0]['permissible']) == 1) {
                    $arr[$ops[0]['rowIndex']][$ops[0]['columnIndex']] = current($ops[0]['permissible']);
                    continue;
                }
    
                foreach ($ops[0]['permissible'] as $value) {
                    $tmp = $arr;
                    $tmp[$ops[0]['rowIndex']][$ops[0]['columnIndex']] = $value;
                    if ($result = $this->solve_it($tmp)) {
                        return $this->solve_it($tmp);
                    }
                }
    
                return false;
            }
        }
    
        private function sortOps($a, $b) {
            $a = count($a['permissible']);
            $b = count($b['permissible']);
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        }
    
        public function getResult() {
            foreach ($this->comming_arr as $k => $row) {
                foreach ($row as $kk => $r) {
                    echo $r;
                }
                echo "-";              
            }
        }
    
        public function __destruct() {
            $this->time_tracking['end'] = microtime(true);
            $time = $this->time_tracking['end'] - $this->time_tracking['start'];
            echo number_format($time, 3);
        }
    
    }

    
    $arr = array(
        array($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]),
        array($data[9], $data[10], $data[11], $data[12], $data[13], $data[14], $data[15], $data[16], $data[17]),
        array($data[18], $data[19], $data[20], $data[21], $data[22], $data[23], $data[24], $data[25], $data[26]),
        array($data[27], $data[28], $data[29], $data[30], $data[31], $data[32], $data[33], $data[34], $data[35]),
        array($data[36], $data[37], $data[38], $data[39], $data[40], $data[41], $data[42], $data[43], $data[44]),
        array($data[45], $data[46], $data[47], $data[48], $data[49], $data[50], $data[51], $data[52], $data[53]),
        array($data[54], $data[55], $data[56], $data[57], $data[58], $data[59], $data[60], $data[61], $data[62]),
        array($data[63], $data[64], $data[65], $data[66], $data[67], $data[68], $data[69], $data[70], $data[71]),
        array($data[72], $data[73], $data[74], $data[75], $data[76], $data[77], $data[78], $data[79], $data[80]),
    );

    $game = new Sudoku();
    $game->solve_it($arr);
    if (!$game->getResult()) {
        return 'error';
    }

}else {
    return 'error';
}


?>