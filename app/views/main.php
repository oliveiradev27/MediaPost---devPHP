<?php require('commons/header.php'); ?>
    <style>
        .table tr td:last-child, .table tr th:last-child{
            text-align: right;
        }

        .table tr td:last-child button:last-child,
        .table tr th:last-child button:last-child {
            margin-left: 5px;
        }
    </style>
    <div id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h1 class="title">Gerenciamento de Contatos</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div id="search-box">
                        <form class="form-inline">  
                            <div class="input-group">
                                <input type="text" placeholder="Pesquisar.." class="form-control" name="search" id="search" value="">
                            </div>
                            <a class="btn btn-success" href="">Limpar</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <table id="table-contatos" class="table">
                        <thead>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>
                                <button class="btn btn-dark" data-toggle="modal" data-target="#modal">Inserir novo</button>
                            </th>
                        </thead>
                        <tbody>
                         
                        </tbody>   
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div id="pagination-box">
                        <nav aria-label="Paginação de contatos" id="pagination-contatos" >
                            <ul class="pagination">
                            </ul>
                        </nav>
                     </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="form-contato" name="form-contato">
                        <input type="hidden" name="id" id="id" value="">
                        <label for="nome">Nome:</label>
                        <div class="input-group">
                        <input type="text" class="form-control" name="nome" id="nome" value="" required>
                        </div>
                        <ul class="nav nav-tabs" id="contatos-dados-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab-emails"  data-toggle="tab" role="tab" aria-controls="emails-tab" aria-selected="true">E-mails</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-telefones" data-toggle="tab" role="tab" aria-controls="telefones-tab"  aria-selected="false">Telefones</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-dados">
                            <div class="tab-pane fade show active" id="tab-emails" role="tabpanel" aria-labelledby="emails-tab">
                                <table id="contatos-table-emails" class="table">
                                    <thead>
                                        <th>E-mail</th>
                                        <th>Tipo</th>
                                        <th>
                                            <button class="btn btn-dark" data-event="add-by-tipo" data-type="emails">Adicionar</button>
                                        </th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-telefones" role="tabpanel" aria-labelledby="telefones-tab">
                                <table id="contatos-table-telefones" class="table">
                                    <thead>
                                        <th>Telefone</th>
                                        <th>Tipo</th>
                                        <th>
                                            <button class="btn btn-dark" data-event="add-by-tipo" data-type="telefones">Adicionar</button>
                                        </th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button id="save-contato" type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-adicional-infos" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal-adicional"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" name="form-adicional" id="form-adicional">
                    <label id="label-descricao" for="descricao"></label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="descricao" id="descricao" value="" required>
                    </div>
                    <label id="label-tipo" for="tipo">Tipo:</label>
                    <div class="input-group">
                        <select name="tipo" id="tipo"  class="form-control"></select>
                    </div>
                    <input type="hidden" id="t" name="t" value="">
                    <input type="hidden" id="adicional-id" name="adicional-id" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="save-adicionais" data-event="save-adicionais" class="btn btn-primary">Salvar</button>
            </div>
            </div>
        </div>
    </div>
<?php require('commons/footer.php'); ?>