<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dropbox_chooser_ft extends EE_Fieldtype {
	
	var $info = array(
		'name'		=> 'Dropbox Chooser',
		'version'	=> '0.1'
	);
	
	// --------------------------------------------------------------------
	
	/**
	 * Display Field on Publish
	 *
	 * @access	public
	 * @param	existing data
	 * @return	field html
	 *
	 */
	function display_field($data)
	{

		$dropboxLinktype = $this->settings['link_type'];
		$dropboxMultiselect = ($this->settings['multiselect'] == 'multiselect')?'true':'false';
		$dropboxField = $this->field_name;

		if ($data)
		{
			$files = explode(', ', $data);
			$links = '';
			for($i = 0; $i < count($files); $i++) {
		        $links .= '<a href="' . $files[$i] . '" target="_blank">' . $files[$i] .'</a><br>';
		    }
			$dropboxExisting = $links;
		}



		$this->_cp_js();

		$dbfield = '';
		$dbfield = '<input type="dropbox-chooser" name="' . $dropboxField .'" style="visibility: hidden;" data-link-type="' . $dropboxLinktype .'" data-multiselect="' . $dropboxMultiselect .'" id="db-chooser" value="' . $data . '"/>';
		$dbfield .= '<div id="dropbox-chooser-urls">';
		if (isset($dropboxExisting)) {
			$dbfield .= $dropboxExisting;
		}
		$dbfield .= '</div>';		

		return $dbfield;

	}
	
	// --------------------------------------------------------------------
		
	/**
	 * Replace tag
	 *
	 * @access	public
	 * @param	field contents
	 * @return	replacement text
	 *
	 */
	function replace_tag($data, $params = array(), $tagdata = FALSE)
	{
		
		$r = '';
		$r = $data;

		// Unserialize the photo data
/*		$picArray = unserialize(urldecode($data));
		$pic = $picArray[0];
		
		$r = '';
		
		$r .= $pic;*/
		
		return $r;

	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Display Global Settings
	 *
	 * @access	public
	 * @return	form contents
	 *
	 */
	function display_global_settings()
	{

        	$this->EE->lang->loadfile('dropbox_chooser');
		
			$val = array_merge($this->settings, $_POST);
			
		    $form = form_label(lang('your_app_key_label'), 'your_app_key').NBS.form_input('your_app_key', $val['your_app_key']);

		    return $form;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Save Global Settings
	 *
	 * @access	public
	 * @return	global settings
	 *
	 */
	function save_global_settings()
	{
			return array_merge($this->settings, $_POST);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Display Settings Screen
	 *
	 * @access	public
	 * @return	default global settings
	 *
	 */
	function display_settings($data)
	{

        $this->EE->load->library('table');
        $this->EE->lang->loadfile('dropbox_chooser');	
		
		$multiselect	= isset($data['multiselect']) ? $data['multiselect'] : $this->settings['multiselect'];
		$link_type	= isset($data['link_type']) ? $data['link_type'] : $this->settings['link_type'];
		$your_app_key		= isset($data['your_app_key']) ? $data['your_app_key'] : $this->settings['your_app_key'];

		$this->EE->table->add_row(
			lang('multiselect_label', 'multiselect'),
			form_checkbox('multiselect', 'multiselect', $multiselect)
		);
		
		$this->EE->table->add_row(
			lang('link_type_label', 'link_type'),
			form_radio('link_type', 'preview', ($link_type == 'preview')?TRUE:FALSE , 'id="link_type_preview"') . ' ' . 
			form_label(lang('link_type_preview'), 'link_type_preview') . ' ' .NBS.NBS. 
			form_radio('link_type', 'direct', ($link_type == 'direct')?TRUE:FALSE , 'id="link_type_direct"') . ' ' . 
			form_label(lang('link_type_direct'), 'link_type_direct')
		);
		$this->EE->table->add_row(
			"link_type",$link_type
		);
		$this->EE->table->add_row(
			"multiselect",$multiselect
		);
		$this->EE->table->add_row(
			"preview",($link_type == 'preview')?'checked':'unchecked'
		);
		$this->EE->table->add_row(
			"direct",($link_type == 'direct')?'checked':'unchecked'
		);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Save Settings
	 *
	 * @access	public
	 * @return	field settings
	 *
	 */
	function save_settings($data)
	{
		return array(
	        'multiselect'  => ee()->input->post('multiselect'),
	        'link_type' => ee()->input->post('link_type')
	    );

	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Install Fieldtype
	 *
	 * @access	public
	 * @return	default global settings
	 *
	 */
	function install()
	{
	    return array(
	        'multiselect'  => '',
	        'link_type' => '',
			'your_app_key' => ''
	    );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Control Panel Javascript
	 *
	 * @access	public
	 * @return	void
	 *
	 */
	function _cp_js()
	{
		// Dropbox Vars
		$dropboxAPI = $this->settings['your_app_key'];
		$dropboxScript = "https://www.dropbox.com/static/api/1/dropins.js";
		$this->EE->cp->add_to_head('<script type="text/javascript" src="' . $dropboxScript . '" id="dropboxjs" data-app-key="' . $dropboxAPI . '"></script>');
		$this->EE->cp->add_to_foot('<script type="text/javascript" src="' . URL_THIRD_THEMES . 'dropbox_chooser/javascript/jquery.dropbox_chooser.js"></script>');		
	}
}

/* End of file ft.dropbox_chooser.php */
/* Location: ./system/expressionengine/third_party/dropbox_chooser/ft.dropbox_chooser.php */