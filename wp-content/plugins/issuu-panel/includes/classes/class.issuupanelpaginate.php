<?php

class IssuuPanelPaginate
{
	private $url = null;

	private $query_var = null;

	private $number_pages = null;

	private $current_page = null;

	private $size = 5;

	public function __construct($url = '', $query_var = '', $number_pages = '', $current_page = '', $size = 5)
	{
		$this->setUrl($url);
		$this->setQueryVar($query_var);
		$this->setNumberPages($number_pages);
		$this->setCurrentPage($current_page);
		$this->setSize($size);
	}

	public function buildPaginateArray()
	{
		if (!is_null($this->number_pages) && !is_null($this->current_page))
		{
			if ($this->number_pages <= $this->size)
			{
				return range(1, $this->number_pages);
			}
			else if ($this->current_page == $this->number_pages)
			{
				return range(($this->number_pages - ($this->size - 1)), $this->number_pages);
			}
			else if ($this->current_page == 1)
			{
				return range(1, (1 + ($this->size - 1)));
			}
			else
			{
				$offset = $this->size - 1;

				if ($offset % 2 == 0)
				{
					$offset = $offset / 2;

					if (($this->current_page - $offset) < 1)
					{
						$y = ($this->current_page - $offset) - 1;
						$offset_less = $offset + $y;
						$offset_more = $offset - $y;

						return range(($this->current_page - $offset_less), ($this->current_page + $offset_more));
					}
					else if (($this->current_page + $offset) > $this->number_pages)
					{
						$y = ($this->current_page + $offset) - $this->number_pages;
						$offset_less = $offset - $y;
						$offset_more = $offset + $y;

						return range(($this->current_page - $offset_more), ($this->current_page + $offset_less));
					}
					else
					{
						return range(($this->current_page - $offset), ($this->current_page + $offset));
					}
				}
				else
				{
					$offset_less = floor($offset / 2);
					$offset_more = ceil($offset / 2);

					if (($this->current_page - $offset_less) < 1)
					{
						$y = ($this->current_page - $offset_less) - 1;
						$offset_less = $offset_less + $y;
						$offset_more = $offset_more - $y;

						return range(($this->current_page - $offset_less), ($this->current_page + $offset_more));
					}
					else if (($this->current_page + $offset_more) > $this->number_pages)
					{
						$y = ($this->current_page + $offset_more) - $this->number_pages;
						$offset_less = $offset_less + $y;
						$offset_more = $offset_more - $y;

						return range(($this->current_page - $offset_less), ($this->current_page + $offset_more));
					}
					else
					{
						return range(($this->current_page - $offset_less), ($this->current_page + $offset_more));
					}
				}
			}
		}
		else
		{
			return null;
		}
	}

	public function paginate($current_page_tag = 'span', $page_number_class = '', $continue_class = '')
	{
		$pages = $this->buildPaginateArray();

		if (is_null($pages) || is_null($this->url) || is_null($this->query_var))
		{
			return '';
		}

		if (!is_string($current_page_tag) || strlen($current_page_tag) == 0)
		{
			$current_page_tag = 'span';
		}

		$content = '';

		if ($pages[0] > 1)
		{
			$content .= "<span class=\"$page_number_class $continue_class\">...</span>";
		}

		foreach ($pages as $page) {
			if ($page != $this->current_page)
			{
				$link = $this->getLink($page, $this->url, $this->query_var);
				$content .= "<a class=\"$page_number_class\" href=\"$link\">$page</a>";
			}
			else
			{
				$content .= "<$current_page_tag class=\"$page_number_class\">$page</$current_page_tag>";
			}
		}

		if ($pages[count($pages) - 1] < $this->number_pages)
		{
			$content .= "<span class=\"$page_number_class $continue_class\">...</span>";
		}

		return $content;
	}

	private function getLink($page, $permalink, $page_name)
	{
		$QUERY_STRING = $_SERVER['QUERY_STRING'];

		if (strpos($permalink, '?') === false)
		{
			if ($QUERY_STRING == "")
			{
				$link = $permalink . '?' . $page_name . '=' . $page;
			}
			else
			{
				if (strpos($QUERY_STRING, $page_name) === false)
				{
					$link = $permalink . '?' . $QUERY_STRING . '&' . $page_name . '=' . $page;
				}
				else
				{

					$QUERY_STRING = preg_replace("/($page_name=\d)/", $page_name . '=' . $page, $QUERY_STRING);
					$link = $permalink . '?' . $QUERY_STRING;
				}
			}
		}
		else
		{
			$pos = strpos($permalink, '?') + 1;
			$substr = substr($permalink, $pos);
			$arr = array($substr => '');
			$QUERY_STRING = strtr($QUERY_STRING, $arr);
			$QUERY_STRING = preg_replace('/\&' . $page_name . '\=\d/', '', $QUERY_STRING);

			if ($QUERY_STRING == "")
			{
				$link = $permalink . '&' . $page_name . '=' . $page;
			}
			else
			{
				if (strpos($QUERY_STRING, $page_name) === false)
				{
					$link = $permalink . '&' . $QUERY_STRING . '&' . $page_name . '=' . $page;
				}
				else
				{
					$QUERY_STRING = preg_replace("/($page_name=\d)/", $page_name . '=' . $page, $QUERY_STRING);
					$link = $permalink . '&' . $QUERY_STRING;
				}
			}
		}

		return preg_replace('/\&{2,}/', '&', $link);
	}

	public function setUrl($url)
	{
		if (is_string($url) && strlen($url) > 0)
		{
			$this->url = $url;
		}
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setQueryVar($query_var)
	{
		if (is_string($query_var)  && strlen($query_var) > 0)
		{
			$this->query_var = $query_var;
		}
	}

	public function getQueryVar()
	{
		return $this->query_var;
	}

	public function setNumberPages($number_pages)
	{
		if (is_numeric($number_pages) && (intval($number_pages) == floatval($number_pages)))
		{
			$this->number_pages = intval($number_pages);
		}
	}

	public function getNumberPages()
	{
		return $this->number_pages;
	}

	public function setCurrentPage($current_page)
	{
		if (is_numeric($current_page) && (intval($current_page) == floatval($current_page)))
		{
			$this->current_page = intval($current_page);
		}
	}

	public function getCurrentPage()
	{
		return $this->current_page;
	}

	public function setSize($size)
	{
		if (is_numeric($size) && (intval($size) == floatval($size)))
		{
			$this->size = intval($size);
		}
	}

	public function getSize()
	{
		return $this->size;
	}
}