<?php
$root = filter_input(INPUT_SERVER, "DOCUMENT_ROOT");
header('Location: '.$root);
