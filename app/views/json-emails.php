<?php
$emails = $data['emails']; 
if (is_array($emails) && count($emails) > 0) {
    http_response_code(200);
    $json = [];
    foreach ($emails as $email) 
        $json[] = [
                'id'        => $email->getId(),
                'email'     => utf8_encode($email->getDescricao()),
                "tipo"      => utf8_encode($email->getTipo())
        ];
    
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
} else if (is_object($emails)) {
    echo json_encode(
            [
                'id'            => $emails->getId(),
                'descricao'     => utf8_encode($emails->getDescricao()),
                "tipo"          => $emails->getTipo()
            ], 
            JSON_UNESCAPED_UNICODE
        );
} else {
    http_response_code(404);
}