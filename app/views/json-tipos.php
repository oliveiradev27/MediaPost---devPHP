<?php
$tipos = $data['tipos']; 
if (is_array($tipos) && count($tipos) > 0) {
    http_response_code(200);
    $json = [];
    foreach ($tipos as $tipo) 
        $json[] = [
                'id'       => $tipo->getId(),
                'tipo'     => utf8_encode($tipo->getDescricao()),
        ];
    
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
} else if (is_object($tipos)) {
    echo json_encode(
            [
                'id'      => $tipos->getId(),
                'tipo'    => utf8_encode($tipos->getDescricao()),
            ], 
            JSON_UNESCAPED_UNICODE
        );
} else {
    http_response_code(404);
}