<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function view( $page = 'monitoring' )
	{
		$this->load->helper('url');
	
		if(!file_exists('../codeigniter/application/views/pages/' . $page . '.php')) {
			show_404();
		}
	
		$data['title'] = $page;
		$data['charts'] = $data['tables'] = $data['forms'] = $data['bselements'] = '';
		$data['bsgrid'] = $data['blank'] = $data['home'] = $data['monitoring'] = '';
		$data['dropdown_chart'] = $data['site'] = $data['node'] = '';
		$data['jsfile'] = $data['gmap'] = $data['commhealth'] = $data['analysisdyna'] = '';
		$data['sentnodetotal'] = $data['rainfall'] = $data['lsbchange'] = '';
		$data['accel'] = $data['showplots'] = $data['showdateplots'] = '';

		switch ($page) {
			case 'home':
				$data['home'] = 'class="active"';
				break;
			
			case 'monitoring':
				$data['monitoring'] = 'class="active"';
				$data['jsfile'] = '<script src="js/dewslandslide/dewsalert.js"></script>';
				$data['gmap'] = '<script src="js/dewslandslide/dewsmaps.js"></script>';
				break;
				
			case 'dropdown_chart':
				$data['dropdown_chart'] = 'class="active"';
				break;
				
			case 'site':
				$data['showplots'] = 'showSitePlots(this.form)';
				$data['showdateplots'] = "showDateSitePlots(document.getElementById('formGeneral'))";
				
				$data['dropdown_chart'] = 'class="active"';
				$data['jsfile'] = '<script src="js/dewslandslide/dewsposition.js"></script>';
				$data['gmap'] = '<script src="js/dewslandslide/dewsmaps.js"></script>';
				$data['commhealth'] = '<script src="js/dewslandslide/dewscommhealth.js"></script>';
				$data['analysisdyna'] = '<script src="js/dewslandslide/dewsanalysisdyna.js"></script>';
				$data['sentnodetotal'] = '<script src="js/dewslandslide/dewssentnodetotal.js"></script>';
				$data['rainfall'] = '<script src="js/dewslandslide/dewsrainfall.js"></script>';
				break;
				
			case 'node':
				$data['showplots'] = 'showNodePlots(this.form)';
				$data['showdateplots'] = "showDateNodePlots(document.getElementById('formGeneral'))";
			
				$data['dropdown_chart'] = 'class="active"';
				$data['jsfile'] = '<script src="js/dewslandslide/dewsposition.js"></script>';
				$data['gmap'] = '<script src="js/dewslandslide/dewsmaps.js"></script>';
				$data['rainfall'] = '<script src="js/dewslandslide/dewsrainfall.js"></script>';
				$data['lsbchange'] = '<script src="js/dewslandslide/dewslsbchange.js"></script>';
				$data['accel'] = '<script src="js/dewslandslide/dewsaccel.js"></script>';
				break;
			
			case 'charts':
				$data['charts'] = 'class="active"';
				break;
				
			case 'tables':
				$data['tables'] = 'class="active"';
				break;
				
			case 'forms':
				$data['forms'] = 'class="active"';
				break;
				
			case 'bselements':
				$data['bselements'] = 'class="active"';
				break;
			
			case 'bsgrid':
				$data['bsgrid'] = 'class="active"';
				break;
			
			case 'blank':
				$data['blank'] = 'class="active"';
				break;
			
			default:
				break;
		}
	
		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('pages/' . $page, $data);
		$this->load->view('templates/footer');
	}

}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */