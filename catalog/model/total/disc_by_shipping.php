<?php
class ModelTotaldiscbyshipping extends Model {

    public function getTotal(&$total_data, &$total, &$taxes) {

        $code = $this->config->get('disc_by_shipping_code');
        if ( isset($this->session->data['shipping_method']['code']) && !empty($code) && is_string(stristr($this->session->data['shipping_method']['code'],$code ))) {

            $min = $this->config->get('disc_by_shipping_min');
            if ( is_numeric($min) && $total < $min ) return;
            $max = $this->config->get('disc_by_shipping_max');
            if ( is_numeric($max) && $total > $max ) return;

            $this->language->load('total/disc_by_shipping');
            
    
            $cats = $this->config->get('disc_by_shipping_categories');
            if (!empty($cats) && in_array(0,$cats)) $cats = array();
            $discount = $this->config->get('disc_by_shipping_amount');
            $percent = $this->config->get('disc_by_shipping_percent');

            if ( empty($cats) ) {
                if ( $percent ) $discount = ( $total * $discount ) / 100;
            } else { # discount on selected categories only
                $this->load->model('catalog/product');
                $products = $this->cart->getProducts();

                $discount_p = 0;
                
                foreach ($products as $product) {
                    $categories = $this->model_catalog_product->getCategories($product['product_id']);
                    foreach ($categories as $category) { 
                        if ( in_array($category['category_id'],$cats) ) {
                            if ( $percent ) { 
                                $discount_p += ( $product['total'] * $discount ) / 100;
                                break;
                            } else {
                                break 2;
                            }
                        }
                    }
                }
                if ( $percent ) $discount = $discount_p;
            }
            $msgs = $this->config->get('disc_by_shipping_msg');
            if ( !is_array($msgs) || empty($msgs[$this->config->get('config_language_id')]) ) {
                $msg = $this->language->get('text_disc_by_shipping');
            } else {
                $msg = $msgs[$this->config->get('config_language_id')];
            }

            $total_data[] = array( 
                'code'       => 'disc_by_shipping',
                'title'      => $msg,
                'text'       => $this->currency->format($discount), 
                'value'      => $discount,
                'sort_order' => $this->config->get('disc_by_shipping_sort_order')
            );

            $total += $discount;
        }
    }
}
?>
