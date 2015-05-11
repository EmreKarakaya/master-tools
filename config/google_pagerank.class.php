<?php

class PageRank {
	function __construct($url) {
		$url = 'info:' . $url;
		$hash = '6' . $this->c($this->e($this->b($url)));
		$fetch = 'http://toolbarqueries.google.com/tbr?client=navclient-auto&ch=' . $hash . '&ie=UTF-8&oe=UTF-8&features=Rank&q=' . $url;
		if(function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $fetch);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$out = curl_exec($ch);
			curl_close($ch);
		} else {
			$out = file_get_contents($fetch);
		}
		$out = trim($out);
		if(strlen($out) > 0) {
			$this->pr = substr($out, 9);
		} else {
			$this->pr = "Bilinmiyor..";
		}
	}

	function b($hash) {
		$j = array();
		$length = strlen($hash);
        for($i = 0; $i < $length; $i++) {
        	$j[$i] = ord($hash[$i]);
        }
        return $j;
    }
	function c($l) {
		$l = ((($l / 7) << 2) | (($this->h($l, 13)) & 7));
		$j = array();
		$j[0] = $l;
		for($i = 1; $i < 20; $i++) {
			$j[$i] = $j[$i - 1] - 9;
		}
		$l = $this->e($this->g($j), 80);
		return $l;
	}
	function e($hash) {
		$r = 3862272608;
        $j = count($hash);
        $p = 2654435769;
        $o = 2654435769;
        $n = 3862272608;
        $l = 0;
        $m = $j;
        $q = array();
        while ($m >= 12) {
            $p += ($hash[$l] + ($hash[$l + 1] << 8) + ($hash[$l + 2] << 16) + ($hash[$l + 3] << 24));
            $o += ($hash[$l + 4] + ($hash[$l + 5] << 8) + ($hash[$l + 6] << 16) + ($hash[$l + 7] << 24));
            $n += ($hash[$l + 8] + ($hash[$l + 9] << 8) + ($hash[$l + 10] << 16) + ($hash[$l + 11] << 24));
            $q = $this->s($p, $o, $n);
            $p = $q[0];
            $o = $q[1];
            $n = $q[2];
            $l += 12;
            $m -= 12;
        }
        $n += $j;
        switch ($m) {
        case 11:
            $n += $hash[$l + 10] << 24;
        case 10:
            $n += $hash[$l + 9] << 16;
        case 9:
            $n += $hash[$l + 8] << 8;
        case 8:
            $o += $hash[$l + 7] << 24;
        case 7:
            $o += $hash[$l + 6] << 16;
        case 6:
            $o += $hash[$l + 5] << 8;
        case 5:
            $o += $hash[$l + 4];
        case 4:
            $p += $hash[$l + 3] << 24;
        case 3:
            $p += $hash[$l + 2] << 16;
        case 2:
            $p += $hash[$l + 1] << 8;
        case 1:
            $p += $hash[$l];
        }
        $q = $this->s($p, $o, $n);
        return ($q[2] < 0) ? (4294967296 + $q[2]) : $q[2];
	}
	function f($j, $i) {
        $k = 2147483648;
        if ($k & $j) {
            $j = $j >> 1;
            $j &= ~$k;
            $j |= 1073741824;
            $j = $j >> ($i - 1);
        } else {
            $j = $j >> $i;
        }
        return $j;
    }

    function g($j) {
    	$l = array();
    	$length = count($j);
    	for($k = 0; $k < $length; $k++) {
    	    for ($m = $k * 4; $m <= $k * 4 + 3; $m++) {
                $l[$m] = $j[$k] & 255;
                $j[$k] = $this->f($j[$k], 8);
            }
    	}
        return $l;
    }

    function h($j, $l) {
        $k = floor($j / $l);
        return ($j - $k * $l);
    }
	function s($t, $k, $u) {
		$t -= $k;
		$t -= $u;
		$t ^= ($this->f($u, 13));
		$k -= $u;
		$k -= $t;
		$k ^= ($t << 8);
		$u -= $t;
		$u -= $k;
		$u ^= ($this->f($k, 13));
		$t -= $k;
		$t -= $u;
		$t ^= ($this->f($u, 12));
		$k -= $u;
		$k -= $t;
		$k ^= ($t << 16);
		$u -= $t;
		$u -= $k;
		$u ^= ($this->f($k, 5));
		$t -= $k;
		$t -= $u;
		$t ^= ($this->f($u, 3));
		$k -= $u;
		$k -= $t;
		$k ^= ($t << 10);
		$u -= $t;
		$u -= $k;
		$u ^= ($this->f($k, 15));
		return array($t, $k, $u);
	}
}

?>