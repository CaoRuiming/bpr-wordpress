<?php

if (!class_exists('IssuuServiceAPI'))
{
    require(dirname(__FILE__) . '/class.issuuserviceapi.php');
}

/**
*   Classe IssuuDocumentEmbed
*
*   @author Pedro Marcelo de Sá Alves
*   @link https://github.com/pedromarcelojava/
*   @version 1.2
*/
class IssuuDocumentEmbed extends IssuuServiceAPI
{

    /**
    *   Método de listagem da seção Bookmark
    *
    *   @access protected
    *   @var string
    */
    protected $list = 'issuu.document_embeds.list';

    /**
    *   Método de exclusão da seção Bookmark
    *
    *   @access protected
    *   @var string
    */
    protected $delete = 'issuu.document_embed.delete';

    /**
    *   Slug da seção
    *
    *   @access protected
    *   @var string
    */
    protected $slug_section = 'documentEmbed';

    /**
    *   IssuuDocumentEmbed::add()
    *
    *   Relacionado ao método issuu.document_embed.add da API.
    *   Cria um embed de um determinado documento que será mostrado
    *   no site do Issuu
    *
    *   @access public
    *   @param array $params Correspondente aos parâmetros da requisição
    *   @return array Retorna um array com a resposta da requisição
    */
    public function add($params)
    {
        $params['action'] = 'issuu.document_embed.add';
        
        return $this->returnSingleResult($params);
    }

    /**
    *   IssuuDocumentEmbed::update()
    *
    *   Relacionado ao método issuu.document_embed.update da API.
    *   Atualiza os dados de um determinado embed
    *
    *   @access public
    *   @param array $params Correspondente aos parâmetros da requisição
    *   @return array Retorna um array com a resposta da requisição
    */
    public function update($params)
    {
        $params['action'] = 'issuu.document_embed.update';
        
        return $this->returnSingleResult($params);
    }

    /**
    *   IssuuDocumentEmbed::getHtmlCode()
    *
    *   Relacionado ao método issuu.document_embed.get_html_code da API.
    *   Retorna um código HTML de um determinado embed
    *
    *   @access public
    *   @param array $params Correspondente aos parâmetros da requisição
    *   @return array Retorna um array com a resposta da requisição
    */
    public function getHtmlCode($params)
    {
        $params['action'] = 'issuu.document_embed.get_html_code';
        $this->setParams($params);

        return $this->curlRequest($this->getApiUrl(), $this->getParams());
    }

    /**
    *   IssuuDocumentEmbed::clearObjectJson()
    *
    *   Valida e formata os atributos do objeto do documento embed.
    *
    *   @access protected
    *   @param object $document_embed Correspondente ao objeto do documento embed
    *   @return object Retorna um novo objeto do documento embed devidamente validado
    */
    protected function clearObjectJson($document_embed)
    {
        $embed = new stdClass();

        $embed->id = $this->validFieldJson($document_embed, 'id', 1);
        $embed->dataConfigId = $this->validFieldJson($document_embed, 'dataConfigId');
        $embed->documentId = $this->validFieldJson($document_embed, 'documentId');
        $embed->readerStartPage = $this->validFieldJson($document_embed, 'readerStartPage', 1);
        $embed->width = $this->validFieldJson($document_embed, 'width', 1);
        $embed->height = $this->validFieldJson($document_embed, 'height', 1);
        $embed->created = $this->validFieldJson($document_embed, 'created');

        return $embed;
    }

    /**
    *   IssuuDocumentEmbed::clearObjectXML()
    *
    *   Valida e formata os atributos do objeto do documento embed.
    *
    *   @access protected
    *   @param object $document_embed Correspondente ao objeto do documento embed
    *   @return object Retorna um novo objeto do documento embed devidamente validado
    */
    protected function clearObjectXML($document_embed)
    {
        $embed = new stdClass();

        $embed->id = $this->validFieldXML($document_embed, 'id', 1);
        $embed->dataConfigId = $this->validFieldXML($document_embed, 'dataConfigId');
        $embed->documentId = $this->validFieldXML($document_embed, 'documentId');
        $embed->readerStartPage = $this->validFieldXML($document_embed, 'readerStartPage', 1);
        $embed->width = $this->validFieldXML($document_embed, 'width', 1);
        $embed->height = $this->validFieldXML($document_embed, 'height', 1);
        $embed->created = $this->validFieldXML($document_embed, 'created');

        return $embed;
    }
}