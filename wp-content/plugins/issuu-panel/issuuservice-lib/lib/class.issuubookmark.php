<?php

if (!class_exists('IssuuServiceAPI'))
{
    require(dirname(__FILE__) . '/class.issuuserviceapi.php');
}

/**
*   Classe IssuuBookmark
*
*   @author Pedro Marcelo de Sá Alves
*   @link https://github.com/pedromarcelojava/
*   @version 1.2
*/
class IssuuBookmark extends IssuuServiceAPI
{

    /**
    *   Método de listagem da seção Bookmark
    *
    *   @access protected
    *   @var string
    */
    protected $list = 'issuu.bookmarks.list';

    /**
    *   Método de exclusão da seção Bookmark
    *
    *   @access protected
    *   @var string
    */
    protected $delete = 'issuu.bookmark.delete';

    /**
    *   Slug da seção
    *
    *   @access protected
    *   @var string
    */
    protected $slug_section = 'bookmark';

    /**
    *   IssuuBookmark::add()
    *
    *   Relacionado ao método issuu.bookmark.add da API.
    *   Adiciona um marcador em qualquer documento.
    *
    *   @access public
    *   @param array $params Correspondente aos parâmetros da requisição
    *   @return array Retorna um array com a resposta da requisição
    */
    public function add($params = array())
    {
        $params['action'] = 'issuu.bookmark.add';

        return $this->returnSingleResult($params);
    }


    /**
    *   IssuuBookmark::clearObjectXML()
    *
    *   Valida e formata os atributos do objeto do marcador.
    *
    *   @access protected
    *   @param object $bookmark Correspondente ao objeto do marcador
    *   @return object Retorna um novo objeto do marcador devidamente validado
    */
    protected function clearObjectXML($bookmark)
    {
        $mark = new stdClass();

        $mark->bookmarkId = $this->validFieldXML($bookmark, 'bookmarkId');
        $mark->username = $this->validFieldXML($bookmark, 'username');
        $mark->documentId = $this->validFieldXML($bookmark, 'documentId');
        $mark->documentUsername = $this->validFieldXML($bookmark, 'documentUsername');
        $mark->name = $this->validFieldXML($bookmark, 'name');
        $mark->title = $this->validFieldXML($bookmark, 'title');
        $mark->title = $this->validFieldXML($bookmark, 'title');
        $mark->page = $this->validFieldXML($bookmark, 'page', 1);
        $mark->ep = $this->validFieldXML($bookmark, 'ep', 1);
        $mark->description = $this->validFieldXML($bookmark, 'description');
        $mark->created = $this->validFieldXML($bookmark, 'created');

        if (isset($bookmark->folders))
        {
            $mark->folders = array();

            foreach ($bookmark->folders->folder as $folder) {
                $mark->folders[] = (string) $folder['id'];
            }
        }

        return $mark;
    }

    /**
    *   IssuuBookmark::clearObjectJson()
    *
    *   Valida e formata os atributos do objeto do marcador.
    *
    *   @access protected
    *   @param object $bookmark Correspondente ao objeto do marcador
    *   @return object Retorna um novo objeto do marcador devidamente validado
    */
    protected function clearObjectJson($bookmark)
    {
        $mark = new stdClass();

        $mark->bookmarkId = $this->validFieldJson($bookmark, 'bookmarkId');
        $mark->username = $this->validFieldJson($bookmark, 'username');
        $mark->documentId = $this->validFieldJson($bookmark, 'documentId');
        $mark->documentUsername = $this->validFieldJson($bookmark, 'documentUsername');
        $mark->name = $this->validFieldJson($bookmark, 'name');
        $mark->title = $this->validFieldJson($bookmark, 'title');
        $mark->title = $this->validFieldJson($bookmark, 'title');
        $mark->page = $this->validFieldJson($bookmark, 'page', 1);
        $mark->ep = $this->validFieldJson($bookmark, 'ep', 1);
        $mark->description = $this->validFieldJson($bookmark, 'description');
        $mark->created = $this->validFieldJson($bookmark, 'created');

        if (isset($bookmark->folders))
        {
            $mark->folders = array();

            foreach ($bookmark->folders as $folder) {
                $mark->folders[] = (string) $folder;
            }
        }

        return $mark;
    }
}