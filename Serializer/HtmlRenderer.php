<?php
namespace Lemon\RestBundle\Serializer;

class HtmlRenderer
{
    public function render($data)
    {
        $output = "<table>\n";

        current($data);
        $first = key($data);
        end($data);
        $last = key($data);

        reset($data);

        foreach ($data as $key => $value) {
            $output .= "<tr>\n";
            $output .= "<td>" . $key . "</td>\n";
            $output .= "<td>" . $value . "</td>\n";
            $output .= "<tr>\n";
        }

        $output .= "</table>\n";

        return $output;
    }
}