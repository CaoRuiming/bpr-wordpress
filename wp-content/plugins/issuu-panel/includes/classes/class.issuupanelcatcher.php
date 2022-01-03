<?php

class IssuuPanelCatcher
{
	private $currentHookIs = null;
	private $template = null;
	private $params = array();

	public function __construct()
	{
		add_action('get_header', array($this, 'header'), 0);
		add_action('get_header', array($this, 'template'), 1);
		add_action('get_footer', array($this, 'footer'), 0);
		add_action('get_sidebar', array($this, 'sidebar'), 0);
		add_action('the_content', array($this, 'content'), 0);
	}

	public function header()
	{
		$this->params = func_get_args();
		$this->currentHookIs = 'header';
	}

	public function footer()
	{
		$this->params = func_get_args();
		$this->currentHookIs = 'footer';
	}

	public function sidebar()
	{
		$this->params = func_get_args();
		$this->currentHookIs = 'sidebar';
	}

	public function content($content)
	{
		$this->params = array();
		$this->currentHookIs = 'content';
		return $content;
	}

	public function template()
	{
		if (is_404()) $this->template = '404';
		else if (is_page()) $this->template = 'page';
		else if (is_single()) $this->template = 'single';
		else if (is_tag()) $this->template = 'tag';
		else if (is_author()) $this->template = 'author';
		else if (is_archive()) $this->template = 'archive';
		else if (is_attachment()) $this->template = 'attachment';
		else if (is_category()) $this->template = 'category';
		else if (is_date()) $this->template = 'date';
		else if (is_day()) $this->template = 'day';
		else if (is_feed()) $this->template = 'feed';
		else if (is_front_page()) $this->template = 'front_page';
		else if (is_home()) $this->template = 'home';
		else if (is_month()) $this->template = 'month';
		else if (is_search()) $this->template = 'search';
		else if (is_tax()) $this->template = 'tax';
		else if (is_taxonomy_hierarchical()) $this->template = 'taxonomy_hierarchical';
		else if (is_time()) $this->template = 'time';
		else if (is_year()) $this->template = 'year';
	}

    public function inHeader()
    {
        return ($this->getCurrentHookIs() == 'header');
    }

    public function inFooter()
    {
        return ($this->getCurrentHookIs() == 'footer');
    }

    public function inSidebar()
    {
        return ($this->getCurrentHookIs() == 'sidebar');
    }

    public function inContent()
    {
        return ($this->getCurrentHookIs() == 'content');
    }

    /**
     * Gets the value of params.
     *
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Gets the value of currentHookIs.
     *
     * @return mixed
     */
    public function getCurrentHookIs()
    {
        return $this->currentHookIs;
    }

    /**
     * Gets the value of template.
     *
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }
}