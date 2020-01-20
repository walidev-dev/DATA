<?php
function nav_item(string $path,string $title) : string 
{
  $class = 'nav-item';
  if($_SERVER['REQUEST_URI'] === $path) $class.=' active';

  $html =  <<<HTML
           <li class="$class">
               <a class="nav-link" href="$path">$title</a>
           </li>
HTML;

  return $html;

}
