<?php

$str = '{"ret":0,"act":"set_resv","msg":"2017-12-27预约与现有预约冲突","data":null,"ext":null}';

$result = json_decode($str);

print_r($result);