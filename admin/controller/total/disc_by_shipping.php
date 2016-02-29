<?php 
class ControllerTotalDiscountByShipping extends Controller { 
	private $error = array(); 
	 
	public function index() { 
		$this->language->load('total/disc_by_shipping');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('setting/extension');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('disc_by_shipping', $this->request->post);
		
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('localisation/language');
		$this->load->model('catalog/category');
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$this->data['entry_amount'] = $this->language->get('entry_amount');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_range'] = $this->language->get('entry_range');
		$this->data['entry_code'] = $this->language->get('entry_code');
		$this->data['entry_msg'] = $this->language->get('entry_msg');
		$this->data['entry_percent'] = $this->language->get('entry_percent');
		$this->data['entry_categories'] = $this->language->get('entry_categories');
					
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_total'),
			'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('total/disc_by_shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('total/disc_by_shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['categories'] = array(array( 'category_id' => 0, 'name' => 'all'));
        $this->data['categories'] += $this->model_catalog_category->getCategories(array());

        $this->data['disc_by_shipping_msg'] = array();
        foreach (array('status','sort_order','amount','code','min','max','percent','msg','categories') as $field ) {
		  if (isset($this->request->post['disc_by_shipping_'.$field])) {
			$this->data['disc_by_shipping_'.$field] = $this->request->post['disc_by_shipping_'.$field];
		  } else {
			$this->data['disc_by_shipping_'.$field] = $this->config->get('disc_by_shipping_'.$field);
		  }
        }

        if (empty($this->data['disc_by_shipping_categories'])) $this->data['disc_by_shipping_categories'] = array();

        if ( !is_numeric($this->data['disc_by_shipping_min']) ) $this->data['disc_by_shipping_min'] = 0;
        if ( !is_numeric($this->data['disc_by_shipping_max']) ) $this->data['disc_by_shipping_max'] = 999999;

        $this->data['shipping'] = $this->model_setting_extension->getInstalled('shipping');
        $this->data['languages'] = $this->model_localisation_language->getLanguages();
        foreach ($this->data['languages'] as $language) {
            if (empty($this->data['disc_by_shipping_msg'][$language['language_id']])) {
                $this->data['disc_by_shipping_msg'][$language['language_id']] = $this->language->get('text_msg_default');
            }
        }
																		
		$this->template = 'total/disc_by_shipping.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/disc_by_shipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        if ( !is_numeric($this->request->post['disc_by_shipping_min']) || !is_numeric($this->request->post['disc_by_shipping_max']) || $this->request->post['disc_by_shipping_min'] > $this->request->post['disc_by_shipping_max'] ) {
			$this->error['warning'] = $this->language->get('error_range');
        }

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
