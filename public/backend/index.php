<?php
$root = filter_input(INPUT_SERVER, "DOCUMENT_ROOT");
//define( 'ROOT',  );
header('Location: '.$root);
