<?php

use Codrasil\Punchcard\Punchcard;

if (! function_exists('punchcard')) {
    /**
     * Punchcard instance.
     *
     * @param array $params
     * @return \Codrasil\Punchcard\Punchcard
     */
    function punchcard($params = [])
    {
        return new Punchcard($params);
    }
}
