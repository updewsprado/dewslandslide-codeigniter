<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

/**
 * Monitoring/Public Alert Routes
 */
$route['home'] = "monitoring/index";
$route['dashboard'] = "monitoring/index";
$route['monitoring/release_form'] = "pubrelease/index/alert_release_form";
$route['monitoring/events'] = "pubrelease/index/monitoring_events_all";
$route['monitoring/events/(:num)/(:num)'] = "pubrelease/index/monitoring_events_individual/$1/$2";
$route['monitoring/events/(:num)'] = "pubrelease/index/monitoring_events_individual/$1";
$route['monitoring/faq'] = "pubrelease/index/monitoring_faq";

$route['monitoring/issues_and_reminders'] = "issues_and_reminders";

/**
 * Bulletin Pages Routes
 */
$route['monitoring/bulletin/view/(:any)'] = "bulletin/view/$1";
$route['monitoring/bulletin/build/(:num)'] = "bulletin/build/$1";
$route['monitoring/bulletin/edit/(:num)/(:any)'] = "bulletin/edit/$1/$2/$3";
$route['monitoring/bulletin/main/(:num)/(:any)'] = "bulletin/main/$1/$2";

/**
 * Reports Pages Routes
 */
$route['reports/accomplishment/form'] = "accomplishment/index";
$route['reports/accomplishment/checker'] = "accomplishment/checker";
$route['reports/site_maintenance/form'] = "sitemaintenance/index";
$route['reports/site_maintenance/all'] = "sitemaintenance/all";
$route['reports/site_maintenance/(:num)'] = "sitemaintenance/individual/$1";

/**
 * Communications Pages Routes
 */
$route['communications/chatterbox'] = "chatterbox/index";
$route['communications/responsetracker'] = "responsetracker/index";
$route['communications/chatterbox/updatecontacts'] = "chatterbox/updatecontacts";
$route['communications/chatterbox/gintagcontacts'] = "chatterbox/get_comm_contacts_gintag";
$route['communications/chatterbox/addcontact'] = "chatterbox/addcontacts";

/**
 * NEW Chatterbox **BETA**
 */

$route['communications/chatterbox_beta'] = "chatterbox_beta/index";
$route['communications/ewi_template'] = "ewi_template/index";
$route['communications/fetchalltemplate'] = "ewi_template/getAllTemplates";
$route['communications/fetchallbackbonetemplate'] = "ewi_template/getAllBackboneTemplates";
$route['communications/addtemplate'] = "ewi_template/addTemplate";
$route['communications/updatetemplate'] = "ewi_template/updateTemplate";
$route['communications/deletetemplate'] = "ewi_template/deleteTemplate";
$route['communications/deletebackbone'] = "ewi_template/deleteBackboneMessage";
$route['communications/getkeypointsviacategory'] = "ewi_template/getKeyViaCategory";
$route['communications/addbackbonemessage'] = "ewi_template/addBackboneMessage";
$route['communications/updatebackbonemessage'] = "ewi_template/updateBackboneMessage";
$route['communications/getkeyinputviatriggertype'] = "ewi_template/getKeyInputViaTriggerType";
$route['communications/getbackboneviastatus'] = "ewi_template/getBbViaAlertStatus";
$route['communications/getrecommendedresponse'] = "ewi_template/getRecommendedResponse";

/**
* General Information Tagging
*/
$route['generalinformation/index'] = "gintagshelper/index";
$route['generalinformation/insertGinTags'] = "gintagshelper/ginTagsEntry";
$route['generalinformation/removeGintagsEntryViaChatterbox'] = "gintagshelper/removeGintagsEntryViaChatterbox";
$route['generalinformation/removeIndividualGintagEntryViaChatterbox'] = "gintagshelper/removeIndiGintagsChatterbox";
$route['generalinformation/getGintagsViaTag'] = "gintagshelper/getGintagsViaTag";
$route['generalinformation/initialize'] = "gintagshelper/initialize";
$route['generalinformation/getanalytics'] = "gintagshelper/getAnalytics";
$route['narrativeAutomation/insert'] = "narrative_generator/insertEwiNarrative";
$route['narrativeautomation/checkack'] = "narrative_generator/checkForAcknowledgement";

/**
 * Data Analysis Pages Routes
 */
$route['data_analysis/node'] = "node_level_page";
$route['data_analysis/node/(:any)/(:any)/(:any)/(:any)'] = "node_level_page";
$route['data_analysis/column'] = "site_level_page";
$route['data_analysis/column/(:any)'] = "site_level_page";
$route['data_analysis/surficial'] = "surficial_page";
$route['data_analysis/subsurface'] = "subsurface_page";
$route['data_analysis/sensor_overview'] = "sensor_overview_page";
$route['data_analysis/nodereport'] = "node_report_page";
$route['data_analysis/site_analysis'] = "site_analysis_page";
$route['data_analysis/rainfall_scanner'] = "rainfall_scanner_page";
$route['data_analysis/Eos_onModal/(:any)/(:any)/(:any)/(:any)'] = "Eos_modal";
//Gold
//$route['gold'] = "monitoring/index";
$route['logout'] = "gold/logout";
$route['gold/logout'] = "gold/logout";
$route['gold/node/(:any)/(:num)/(:num)/(:num)'] = "gold/view/node/$1/$2/$3/$4";
$route['gold/node/(:any)/(:num)/(:num)'] = "gold/view/node/$1/$2/$3";
$route['gold/node/(:any)/(:num)'] = "gold/view/node/$1/$2";
$route['gold/site/(:any)/(:num)'] = "gold/view/node/$1/$2";
$route['gold/site/(:any)'] = "gold/view/site/$1";
$route['gold/monitoring'] = "gold/view/monitoring";


$route['gold/publicrelease'] = "pubrelease/index/publicrelease";
$route['gold/publicrelease/individual/(:num)'] = "pubrelease/index/publicrelease_individual/$1";
$route['gold/publicrelease/event/individual/(:num)'] = "pubrelease/index/publicrelease_event_individual/$1";
$route['gold/publicrelease/event/all'] = "pubrelease/index/publicrelease_event_all";
$route['gold/publicrelease/faq'] = "pubrelease/index/publicrelease_faq";

$route['gold/accomplishmentreport'] = "accomplishment/index/accomplishmentreport";
$route['gold/accomplishmentreport/individual/(:num)'] = "gold/view/accomplishmentreport_individual/$1";
$route['gold/accomplishmentreport/all'] = "gold/view/accomplishmentreport_all";

$route['gold/sitemaintenancereport/individual/(:num)'] = "gold/view/sitemaintenancereport_individual/$1";
$route['gold/sitemaintenancereport/all'] = "gold/view/sitemaintenancereport_all";
$route['gold/monitoring_dashboard'] = "monitoring/index";

$route['gold/sample_view'] = "sample/index";
$route['gold/bulletin/(:any)'] = "bulletin/view/$1";
$route['gold/bulletin-builder/(:num)'] = "bulletin/build/$1";
$route['gold/bulletin-editor/(:num)'] = "bulletin/edit/$1";
$route['gold/bulletin-main/(:num)/(:any)'] = "bulletin/main/$1/$2";

$route['default_controller'] = "lin";
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */