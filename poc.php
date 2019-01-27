<?php

$string = <<<CSS

@(#parent1) {

	@(.sub2.active) {

		body { color: #888; }

		@media print { body { color: #333; } }
	}

	code { color: blue; }

}

@(#parent) {
	.sous-style {
		display: none;
	}
}

CSS;



//preg_match_all($pattern, $string, $groups);
//var_export($groups);



class parseCss {
	
	protected $string = '';
	//protected $prefixesStack = ['.p1', '.p2', '.p3', '.s1, .s2, .s3', '.ss1', '.sss1', ' .a1, .a2', '[href="#end"]', '.t1, .t2, .t3'];
	protected $prefixesStack = [];
	protected $pattern = '/(?:[^{}]+){(?:[^{}]+|(?R))*}/s';
	
	function __construct($string) {
		$this->string = $string;
	}
	
	function explode($str) {
		if(is_string($str) and strpos($str, '{') !== false and strpos($str, '{')) {
			preg_match_all($this->pattern, $str, $matches);
			$out = [];
			foreach($matches[0] as $m) {
				$bracketPos = strpos($m, '{');
				$sel = trim(substr($m, 0, $bracketPos));	// TODO : remove comments!
				$content = substr($m, $bracketPos +1, -1);
				$out[$sel] = $this->explode($content);
			}
		}
		else
			return $str;
		return $out;
	}
	
	function render($arr) {
		if(is_string($arr))
			return $arr;
		$out = '';
		foreach($arr as $s => $c) {
			if(strpos($s, '@(') === 0 and substr($s, -1) == ')') {
				array_push($this->prefixesStack, substr($s, 2, -1));
				$out .= $this->render($c);
			}
			else {
				if(is_array($c))
					$c = $this->render($c);
				if(strpos($s, '@') !== 0)
					$s = $this->currentPrefix().' '.$s;
				$out .= $s.' {'."\n".$c."\n".'}'."\n\n";
			}
			
		}
		return $out;
	}
	
	function output() {
		$e = $this->explode($this->string);
		//var_dump($e);
		return $this->render($e);
	}
	
	function currentPrefix($cP = '', $stack = null, $explode = true) {
		if($stack === null) {
			if(empty($this->prefixesStack))
				return '';
			$stack = $this->prefixesStack;
		}
		elseif(empty($stack))
			return $cP;
		if(!$explode)
			return implode(',', $stack);
		while(!empty($stack)) {
			$p = array_shift($stack);
			if(!strpos($p, ',')) {
				$cP .= ($cP ? ' ' : '').$p;
				return $this->currentPrefix($cP, $stack);
			}
			else {
				$out = [];
				foreach(explode(',', $p) as $_p) {
//var_dump($stack);
//var_dump($cP.' '.$_p);
//echo "\n";
					$out[] = $this->currentPrefix($cP.' '.$_p, $stack);
				}
				return implode(', ',$out);
			}
		}
	}
	
	function renderBlock($sel, $content) {
		return $this->currentPrefix();
	}
	
	function __toString() {
		return $this->output();
	}
	
}

echo new parseCss($string);

