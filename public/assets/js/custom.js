jQuery(document).ready(function($) {

    // Variaveis

    var server = 'http://localhost:8080/mediapost/public/';
    var quantContatos = 0;
    var offsetContatos = 0;
    var limitContatos = 5;

    // Requests

    function getContatos(limit, offset) {
        getContatos(limit, offset, null);
    }

    function getContatos(limit, offset, termo) {
        url = server + '?controller=Contatos&action=get&params[]=0&params[]=' + limit + '&params[]=' + offset;
        url += termo != null ? '&params[]=' + termo : "";
        $.getJSON(
            url,
            function(data) {
                if (data) {
                    var items = [];
                    var html = "";
                    $.each(data, function(key, value) {
                        html += "<tr>"
                        html += "<td>" + value.id + "</td>";
                        html += "<td>" + value.nome + "</td>";
                        html += "<td>"
                        html += "<button data-event=\"del-contato\" class=\"btn btn-danger \" data-id=\"" + value.id + "\">"
                        html += "Excluir"
                        html += "</button>"
                        html += "<button data-event=\"upd-contato\" class=\"btn btn-info\" data-id=\"" + value.id + "\">"
                        html += "Visualizar"
                        html += "</button>"
                        html += "</td>"
                        html += "</tr>";
                        items.push("id: " + value.id + " - nome: " + value.nome);
                    });
                    //$('.table tbody tr').remove();
                    $('#table-contatos tbody tr').fadeOut(0);
                    $('#table-contatos tbody').prepend(html);
                }
            }
        ).fail(function(jqXHR) {
            if (jqXHR.status == 404) {
                var html = "";
                html += "<tr>"
                html += "<td colspan=\"2\">Não encontrados.</td>";
                html += "</tr>";
                $('#table-contatos tbody tr').fadeOut(0);
                $('#table-contatos tbody').prepend(html);
            }
        });
    }

    function getEmailsByContato(id, limit, offset) {
        $.getJSON(
            server + '?controller=Emails&action=getByContato&params=' + id,
            function(data, status, jqXHR) {
                if (data) {
                    var html = "";
                    $.each(data, function(key, value) {
                        html += "<tr>"
                        html += "<td>" + value.email + "</td>";
                        html += "<td>" + value.tipo + "</td>";
                        html += "<td>"
                        html += "<button data-event=\"del-email\" class=\"btn btn-danger \" data-id=\"" + value.id + "\">"
                        html += "Excluir"
                        html += "</button>"
                        html += "<button data-event=\"upd-email\" class=\"btn btn-info\" data-id=\"" + value.id + "\">"
                        html += "Alterar"
                        html += "</button>"
                        html += "</td>"
                        html += "</tr>";
                    });
                    //$('.table tbody tr').remove();
                    $('#contatos-table-emails tbody tr').fadeOut(0);
                    $('#contatos-table-emails tbody').prepend(html);
                }
            }
        ).fail(function(jqXHR) {
            if (jqXHR.status == 404) {
                setEmptyTableEmails();
            }
        });

    }

    function getTelefonesByContato(id, limit, offset) {
        $.getJSON(
            server + '?controller=Telefones&action=getByContato&params=' + id,
            function(data) {
                if (data) {
                    var html = "";
                    $.each(data, function(key, value) {
                        html += "<tr>";
                        html += "<td>" + value.numero + "</td>";
                        html += "<td>" + value.tipo + "</td>";
                        html += "<td>";
                        html += "<button data-event=\"del-telefone\" class=\"btn btn-danger \" data-id=\"" + value.id + "\">"
                        html += "Excluir";
                        html += "</button>";
                        html += "<button data-event=\"upd-telefone\" class=\"btn btn-info\" data-id=\"" + value.id + "\">"
                        html += "Alterar";
                        html += "</button>";
                        html += "</td>";
                        html += "</tr>";
                    });
                    $('#contatos-table-telefones tbody tr').fadeOut(0);
                    $('#contatos-table-telefones tbody').prepend(html);
                }
            }
        ).fail(function(jqXHR) {
            if (jqXHR.status == 404) {
                setEmptyTableTelefones();
            }
        });
    }

    function getTipos(tipo) {
        var url = server;
        if (tipo == 'email')
            url += '?controller=TipoEmail&action=get';
        else
            url += '?controller=TipoTelefone&action=get';
        $.getJSON(
            url,
            function(data) {
                if (data) {
                    var html = "";
                    $.each(data, function(key, value) {
                        html += '<option value="' + value.id + '">';
                        html += value.tipo;
                        html += '</option>';
                    });
                    $('#tipo option').remove();
                    $('#tipo').prepend(html);
                }
            }
        );
    }

    function save() {
        var id = $('#id').val();
        var nome = $('#nome').val();
        var objeto = new Object();
        objeto.id = id;
        objeto.nome = nome;
        var contato = JSON.stringify(objeto);
        console.log(contato);
        var url = server;
        if (id > 0 && id != "")
            url += '?controller=Contatos&action=upd';
        else
            url += '?controller=Contatos&action=add';
        $.ajax({
            url: url,
            dataType: "json",
            type: "POST",
            data: contato,
            statusCode: {
                200: function(data) {
                    console.log(data);
                    getContatos(limitContatos, offsetContatos);
                    alert("Salvo com sucesso");
                    $('#id').val(data.id);
                    $('[data-event="add-by-tipo"]').removeAttr('disabled');
                },
                400: function() {
                    alert("Ocorreu um erro e a ação não pode ser concluida!");
                }
            }
        });
    }

    function saveAdicionais() {
        var objeto = new Object();
        objeto.id = $('#adicional-id').val();
        objeto.contatoId = $('#id').val();
        objeto.descricao = $('#descricao').val();
        objeto.tipo = $('#tipo').val();
        var json = JSON.stringify(objeto);
        console.log(json);
        var url = server;
        if ($('#t').val() == 'emails') {
            if (objeto.id != '')
                url += '?controller=Emails&action=upd';
            else
                url += '?controller=Emails&action=add';
        } else {
            if (objeto.id != '')
                url += '?controller=Telefones&action=upd';
            else
                url += '?controller=Telefones&action=add';
        }
        $.ajax({
            url: url,
            dataType: "json",
            type: "POST",
            data: json,
            statusCode: {
                200: function(data) {
                    console.log(data);
                    if (!objeto.id)
                        $('#adicional-id').val(data.id);
                    getTelefonesByContato(objeto.contatoId, 5, 5);
                    getEmailsByContato(objeto.contatoId, 5, 5);
                    getQuantidadeContatos();
                    alert("Salvo com sucesso");
                },
                400: function() {
                    alert("Ocorreu um erro e a ação não pode ser concluida!");
                }
            }
        });
    }
    // Funções

    function getContato(id) {
        $.getJSON(
            server + '?controller=Contatos&action=get&params=' + id,
            function(data) {
                if (data) {
                    $('#nome').val(data.nome);
                }
            }
        );
    }

    function getAdicional(id, tipo) {
        var url = server;
        if (tipo == 'emails')
            url += '?controller=Emails&action=get&params=' + id;
        else
            url += '?controller=Telefones&action=get&params=' + id;

        $.getJSON(
            url,
            function(data) {
                if (data) {
                    $('#descricao').val(data.descricao);
                    $('#tipo option[value="' + data.tipo + '"]').attr('selected', true);
                }
            }
        );
    }

    function delContato(id) {
        $.getJSON(
                server + '?controller=Contatos&action=del&params=' + id,
                function(data) {
                    getContatos(limitContatos, offsetContatos);
                })
            .fail(function(data, textStatus, error) {
                console.log(textStatus);
            });
    }

    function delAdicional(id, tipo) {
        var url = server;
        if (tipo == 'emails')
            url += '?controller=Emails&action=del&params=' + id;
        else
            url += '?controller=Telefones&action=del&params=' + id;
        $.getJSON(
                url,
                function(data) {
                    getTelefonesByContato($('#id').val(), 5, 5);
                    getEmailsByContato($('#id').val(), 5, 5);
                })
            .fail(function(data, textStatus, error) {
                console.log(textStatus);
            });
    }

    function getQuantidadeContatos() {
        $.getJSON(
            server + '?controller=Contatos&action=getQuantidade',
            function(data) {
                quantContatos = data.quantidade;
                console.log("quantidade: " + quantContatos);
                createPaginacao();
            });

    }

    function setEmptyTableTelefones() {
        var html = "";
        html += "<tr>"
        html += "<td colspan=\"2\">Não encontrados.</td>";
        html += "</tr>";
        $('#contatos-table-telefones tbody tr').fadeOut(0);
        $('#contatos-table-telefones tbody').prepend(html);
    }

    function setEmptyTableEmails() {
        var html = "";
        html += "<tr>"
        html += "<td colspan=\"2\">Não encontrados.</td>";
        html += "</tr>";
        $('#contatos-table-emails tbody tr').fadeOut(0);
        $('#contatos-table-emails tbody').prepend(html);
    }

    function createPaginacao() {
        var totalPaginas = 0;
        totalPaginas = Math.floor(quantContatos / limitContatos);
        console.log();
        var offsetAnterior = (offsetContatos - limitContatos) >= 0 ? (offsetContatos - limitContatos) : 0;
        var offsetProximo = (parseInt(offsetContatos) + parseInt(limitContatos)) <= quantContatos ? parseInt(offsetContatos) + parseInt(limitContatos) : parseInt(offsetContatos);
        var html = '<a class="page-link" tabindex="-1" data-offset="' + offsetAnterior + '">Anterior</a>';
        for (var i = 0; i <= totalPaginas; i++) {
            html += '<li class="page-item"><a class="page-link" data-offset="' + limitContatos * i + '">' + (i + 1) + '</a></li>';
        }

        html += '<a class="page-link"  data-offset="' + offsetProximo + '">Próximo</a>';
        $('#pagination-contatos .pagination ul').remove();
        $('#pagination-contatos .pagination a').remove();
        $('#pagination-contatos .pagination').prepend(html);
        $('#pagination-contatos .pagination li a[data-offset="' + offsetContatos + '"]').parent().addClass('active');
    }

    function updModal() {
        var id = $('#id').val();
        if (id != "" && id > 0) {
            getContato(id);
            getEmailsByContato(id, 5, 0)
            getTelefonesByContato(id, 5, 0)
            $('#modal').modal();
        }
    }

    function updModalAdicional(tipo) {
        console.log(tipo);
        switch (tipo) {
            case 'emails':
                $('#title-modal-adicional').text('E-mail');
                $('#label-descricao').text('E-mail:');
                $('#descricao').attr('type', 'email');
                $('#descricao').unmask();
                getTipos('email');
                $('#t').val(tipo);
                break;
            case 'telefones':
                $('#title-modal-adicional').text('Telefone:');
                $('#label-descricao').text('Numero:');
                $('#descricao').attr('type', 'text');
                $('#descricao').mask('(99) 99999-9999');
                getTipos('telefone');
                $('#t').val(tipo);
                break;
        }
        var id = $('#adicional-id').val();
        if (id != "")
            getAdicional(id, tipo);

        $('#modal-adicional-infos').modal();
    }
    // Elementos da Interface

    $('#modal').on('hidden.bs.modal', function(e) {
        $('#id').val('');
        $('#nome').val('');
        $('#contatos-table-telefones tbody tr').remove();
        $('#contatos-table-emails tbody tr').remove();
    })

    $('#modal-adicional-infos').on('hidden.bs.modal', function(e) {
        $('#adicional-id').val('');
        $('#descricao').val('');
        $('#tipo option').remove();
        $('#t').val('');
    })

    $('#modal').on('show.bs.modal', function(e) {
        setEmptyTableEmails();
        setEmptyTableTelefones();

        if ($('#id').val() == "")
            $('[data-event="add-by-tipo"]').attr('disabled', true);
        else
            $('[data-event="add-by-tipo"]').attr('disabled', false);
    })

    $('#table-contatos').on('click', '[data-event="del-contato"]', function(event) {
        var id = $(this).attr('data-id');
        delContato(id);
    });

    $('#table-contatos').on('click', '[data-event="upd-contato"]', function(event) {
        var id = $(this).attr('data-id');
        $('#id').val(id);
        updModal();
    });

    $('#save-contato').click(function(event) {
        event.preventDefault();
        var nome = document.getElementById('nome');
        if (nome.checkValidity())
            save();
        else
            alert('O campo nome é obrigatório!');

    });

    $('[data-event="add-by-tipo"]').click(function(event) {
        event.preventDefault();
        updModalAdicional($(this).attr('data-type'));
    });

    $('#contatos-table-telefones').on('click', '[data-event="upd-telefone"]', function(event) {
        event.preventDefault();
        $('#adicional-id').val($(this).attr('data-id'));
        updModalAdicional('telefones');
    });

    $('#contatos-table-telefones').on('click', '[data-event="del-telefone"]', function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        delAdicional(id, "telefones");


    });

    $('#contatos-table-emails').on('click', '[data-event="upd-email"]', function(event) {
        event.preventDefault();
        $('#adicional-id').val($(this).attr('data-id'))
        updModalAdicional('emails');
    });

    $('#contatos-table-emails').on('click', '[data-event="del-email"]', function(event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        delAdicional(id, "emails");
    });

    $('[data-event="save-adicionais"]').click(function(event) {
        event.preventDefault();
        var descricao = document.getElementById('descricao');
        var label = $('#label-descricao').text();
        if (descricao.checkValidity()) {
            saveAdicionais();
        } else {
            if (descricao.value == "")
                alert('O campo ' + label + '  é obrigatório!');
            else
                alert('Formato inválido!');
        }
    });

    $('#pagination-contatos').on('click', '.pagination li a', function(event) {
        event.preventDefault();
        offsetContatos = $(this).attr('data-offset');
        getContatos(limitContatos, offsetContatos);
        getQuantidadeContatos();
    });

    $('#pagination-contatos').on('click', '.pagination > a', function(event) {
        event.preventDefault();
        offsetContatos = $(this).attr('data-offset');
        getContatos(limitContatos, offsetContatos);
        getQuantidadeContatos();
    });

    $('#search').keypress(function() {
        getContatos(limitContatos, offsetContatos, $(this).val());
        $('#pagination-box').hide();
    });
    // Uso das funções

    getContatos(limitContatos, offsetContatos);
    getQuantidadeContatos();
});