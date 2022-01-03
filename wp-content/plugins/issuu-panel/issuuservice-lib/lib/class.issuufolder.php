<?php

if (!class_exists('IssuuServiceAPI'))
{
    require(dirname(__FILE__) . '/class.issuuserviceapi.php');
}

/**
*   Classe IssuuFolder
*
*   @author Pedro Marcelo de Sá Alves
*   @link https://github.com/pedromarcelojava/
*   @version 1.2
*/
class IssuuFolder extends IssuuServiceAPI
{

    /**
    *   Método de listagem da seção Folder
    *
    *   @access protected
    *   @var string
    */
    protected $list = 'issuu.folders.list';

    /**
    *   Método de exclusão da seção Folder
    *
    *   @access protected
    *   @var string
    */
    protected $delete = 'issuu.folder.delete';

    /**
    *   Slug da seção
    *
    *   @access protected
    *   @var string
    */
    protected $slug_section = 'folder';

    /**
    *   IssuuFolder::add()
    *
    *   Relacionado ao método issuu.folder.add da API.
    *   Cria uma pasta vazia na conta. Documentos e marcadores podem
    *   ser adicionados as pastas.
    *
    *   @access public
    *   @param array $params Correspondente aos parâmetros da requisição
    *   @return array Retorna um array com a resposta da requisição
    */
    public function add($params)
    {
        $params['action'] = 'issuu.folder.add';
        
        return $this->returnSingleResult($params);
    }

    /**
    *   IssuuFolder::update()
    *
    *   Relacionado ao método issuu.folder.update da API.
    *   Atualiza os dados de uma determinada pasta.
    *
    *   @access public
    *   @param array $params Correspondente aos parâmetros da requisição
    *   @return array Retorna um array com a resposta da requisição
    */
    public function update($params = array())
    {
        $params['action'] = 'issuu.folder.update';

        return $this->returnSingleResult($params);
    }

    /**
    *   IssuuFolder::clearObjectJson()
    *
    *   Valida e formata os atributos do objeto da pasta.
    *
    *   @access protected
    *   @param object $folder Correspondente ao objeto da pasta
    *   @return object Retorna um novo objeto da pasta devidamente validado
    */
    protected function clearObjectJson($folder)
    {
        $fold = new stdClass();

        $fold->folderId = $this->validFieldJson($folder, 'folderId');
        $fold->username = $this->validFieldJson($folder, 'username');
        $fold->name = $this->validFieldJson($folder, 'name');
        $fold->description = $this->validFieldJson($folder, 'description');
        $fold->description = $this->validFieldJson($folder, 'description');
        $fold->items = $this->validFieldJson($folder, 'items', 1);
        $fold->itemCount = $this->validFieldJson($folder, 'itemCount', 1);
        $fold->ep = $this->validFieldJson($folder, 'ep', 1);
        $fold->created = $this->validFieldJson($folder, 'created');

        return $fold;
    }

    /**
    *   IssuuFolder::clearObjectXML()
    *
    *   Valida e formata os atributos do objeto da pasta.
    *
    *   @access protected
    *   @param object $folder Correspondente ao objeto da pasta
    *   @return object Retorna um novo objeto da pasta devidamente validado
    */
    protected function clearObjectXML($folder)
    {
        $fold = new stdClass();

        $fold->folderId = $this->validFieldXML($folder, 'folderId');
        $fold->username = $this->validFieldXML($folder, 'username');
        $fold->name = $this->validFieldXML($folder, 'name');
        $fold->description = $this->validFieldXML($folder, 'description');
        $fold->items = $this->validFieldXML($folder, 'items', 1);
        $fold->itemCount = $this->validFieldXML($folder, 'itemCount', 1);
        $fold->ep = $this->validFieldXML($folder, 'ep', 1);
        $fold->created = $this->validFieldXML($folder, 'created');

        return $fold;
    }
}