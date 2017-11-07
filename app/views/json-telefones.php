<?php
$telefones = $data['telefones']; 
if (is_array($telefones) && count($telefones) > 0) {
    http_response_code(200);
    $json = [];
    foreach ($telefones as $telefone) 
        $json[] = [
                'id'        => $telefone->getId(),
                'numero'  => utf8_encode($telefone->getDescricao()),
                "tipo"      => utf8_encode($telefone->getTipo())
        ];
    
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
} else if (is_object($telefones)) {
    echo json_encode(
            [
                'id'        => $telefones->getId(),
                'descricao' => utf8_encode($telefones->getDescricao()),
                "tipo"      => $telefones->getTipo()
            ], 
            JSON_UNESCAPED_UNICODE
        );
} else {
    http_response_code(404);
}