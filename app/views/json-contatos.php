<?php
$contatos = $data['contatos']; 
if (is_array($contatos) && count($contatos) > 0) {
    http_response_code(200);
    $json = [];
    foreach ($contatos as $contato) 
        $json[] = [
                'id'     => $contato->getId(),
                'nome'   => utf8_encode($contato->getNome())
        ];
    
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
} else if (is_object($contatos)) {
    echo json_encode(
            [
                'id'     => $contatos->getId(),
                'nome'   => utf8_encode($contatos->getNome())
            ], 
            JSON_UNESCAPED_UNICODE
        );
} else {
    http_response_code(404);
}