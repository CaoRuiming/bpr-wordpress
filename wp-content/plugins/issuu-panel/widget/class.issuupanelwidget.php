<?php

class IssuuPanelWidget extends WP_Widget implements IssuuPanelService
{
	private $config;

	public function __construct()
	{
		parent::__construct(
			false,
			'Issuu Panel',
			array('description' => get_issuu_message('Get and display the last document'))
		);
	}

	public function widget($args, $instance)
	{
		$id = ($instance['issuu_panel_folder'] != '0')? ' id="' . $instance['issuu_panel_folder'] . '"' : '';
		$link = (isset($instance['issuu_panel_url_page']) && trim($instance['issuu_panel_url_page']) != '')?
			' link="' . $instance['issuu_panel_url_page'] . '"' : '';
		$order_by = ' order_by="' . $instance['issuu_panel_order_by'] . '"';

		echo $args['before_widget'];

		if (!empty($instance['issuu_panel_title']))
		{
			echo $args['before_title'];
			echo $instance['issuu_panel_title'];
			echo $args['after_title'];
		}

		echo do_shortcode("[issuu-panel-last-document{$id}{$link}{$order_by}]");
		echo $args['after_widget'];
	}

	public function form($instance)
	{
		$ipanel_folder = $instance['issuu_panel_folder'];
		$ipanel_url_page = $instance['issuu_panel_url_page'];
		$ipanel_order_by = $instance['issuu_panel_order_by'];
		$ipanel_title = $instance['issuu_panel_title'];
		$issuu_panel_api_key = $this->getConfig()->getOptionEntity()->getApiKey();
		$issuu_panel_api_secret = $this->getConfig()->getOptionEntity()->getApiSecret();

		$result = $this->getConfig()->getIssuuServiceApi('IssuuFolder')->issuuList();
		include(ISSUU_PANEL_DIR . 'widget/forms/last-document-shortcode.phtml');
	}

	public function update($new_instance, $old_instance)
	{
		return array_merge($old_instance, $new_instance);
	}

	public function setConfig(IssuuPanelConfig $config)
	{
		$this->config = $config;
	}

	public function getConfig()
	{
		return $this->config;
	}
}