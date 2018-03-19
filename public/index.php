<?php 

include('../Template/Template.php');

$template = new Template();

// Set the template
$template->setTemplate('../Template/extra.tmpl');

// Assign variables and arrays to the template parsing datas to the template
$data = array(
  [
   "Thing" => "roses",
    "Desc"  => "red"
  ],
  [
    "Thing" => "violets",
    "Desc"  => "blue"
  ],
  [
    "Thing" => "you",
    "Desc"  => "able to solve this"
  ],
  [
    "Thing" => "we",
    "Desc"  => "interested in you"
  ]
);

$template->assign("Name", "Riccardo");
$template->assign('Stuff', $data);

echo $template->render(true);
