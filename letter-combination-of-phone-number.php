<?php 


// Сложность 0(n)
function letterCombinations($digits) {
    if(strlen($digits) == 0) {
        return [];
    }

    $layouts = [
        2 => range('a', 'c'),
        3 => range('d', 'f'),
        4 => range('g', 'i'),
        5 => range('j', 'l'),
        6 => range('m', 'o'),
        7 => range('p', 's'),
        8 => range('t', 'v'),
        9 => range('w', 'z')
      ];

      return recursive(0, $digits, $layouts);
}


function recursive ($index, $chars, $layouts, $combine = '') {
    foreach($layouts[$chars[$index]] as $currentLayout) {
        if($layouts[$chars[$index + 1]]) {
            $this->recursive($index + 1, $chars, $layouts, $combine . $currentLayout);
        } else {
            $this->result[] = $combine . $currentLayout;
        }
    }

    return $this->result;
}