<?php
/**
 * @param $str
 * @param bool $color
 */
function _output($str, $color = false)
{
    if (!is_string($str))
        $str = var_export($str, true);
    if ($color){
        switch ($color) {
            case 'blue': $c=34; break;
            case 'purple': $c=35; break;
            case 'cyan': $c=36; break;
            case 'green': $c=32; break;
            case 'yellow': $c=33; break;
            case 'red':
            default:
                $c = 31;
        }
        $str = "\033[{$c}m$str\033[0m";
    }
    echo "$str\n";
}

/**
 * @param $args
 * @param $lib
 * @return array
 * @throws Exception
 */
function parseArgs($args, $lib)
{
    $input = [];
    for ($i = 0; !empty($args[$i]); $i++) {
        foreach ($lib as $a) {
            if ($args[$i] == $a) {
                $input[$a] = $args[++$i] ?? 0;
                continue 2;
            }

            if (preg_match("#^$a=([^='\"]*|('[^']*')|(\"[^\"]*\"))$#", $args[$i], $a)) {
                $exp = explode('=', $args[$i]);
                $input[$exp[0]] = $exp[1];
                continue 2;
            }
        }

        throw new Exception("Unknown param \"{$args[$i]}\"");
    }
    return $input;
}