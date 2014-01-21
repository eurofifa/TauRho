<?php
/*
Plugin Name: EuroFIFA - Online League
Plugin URI: http://eurofifa.com/
Description: This plugin allows you to create and manage online tournaments on your EuroFIFA wordpress driven website. For more information on the development please visit http://eurofifa.com/online website. 
Version: 0.3.0.3
Author: MagoR
*/

/**
* Loading class for the WordPress plugin EuroFIFA - Online League
* 
* @author 	MagoR
* @package	EuroFIFA League
* @copyright 	Copyright 2013-2014
* 
* @note if unsure, please refer to WordPress documentation for better integration
* @note use wordpress methods and features
* 
*/
class EuroFIFALeagueLoader { 
    
    /**
     * Class Variables
     * 
     * @var $remark bool general switch for true or false clauses currently used by _arrayInput
     * @var $view array|string general conduit to the HTML output usually for strings or associative arrays
     * @var $data array|string secondary conduit to any HTML output usually for strings or associative arrays
     * @var $modules content for conditional or unconditional module include
     * @protected $wpdb callable global variable $wpdb through protected var (eg. $this->wpdb)
     * 
     * @note variables like $view and $data shall be called as $result and $data at the template
     *   
    */
    var $remark = false;
    var $view = false;
    var $data = false;
    var $modules = false;
    protected $wpdb = false;


    /**
     * Constructor
     * 
     * @param none none
     * @return bool
     * 
     * @note default constructor initializes the EuroFIFA League Engine
     * @note defines client and host path as constants (e.g. EF_URL, EF_PATH)
     * @note declares database tables via _defineTables() and determines location with _loadLocation()
     * @note registers WPDB to class variable (protected) $this->wpdb
     * 
    */
    function __construct() {

        global $wpdb;
        
        define( 'EF_URL', WP_PLUGIN_URL.'/eurofifa-league' );
        define( 'EF_PATH', WP_PLUGIN_DIR.'/eurofifa-league' );

        $this->_defineTables();
        $this->_registerWPDB();
        $this->_loadLocation();
    }
    
    /**
     * Constructor Launcher
     * 
     * @param none none
     * @return bool
     * 
     * @note loads constructor for wordpress registry
     * 
    */
    function EuroFIFALeagueLoader(){
	$this->__construct();
    }
    
    /**
     * Location Determinator 
     * 
     * @param none none
     * @return bool on error
     * 
     * @note determines the location of the request (backend or frontend)
     * @note loads appropriate case
     * 
    */
    private function _loadLocation(){ 
        if(is_admin()){
            $this->_loadAdmin();
        }else{
            $this->_loadFrontEnd();
        }
    }
    
    /**
     * Backend Loader
     * 
     * @param none none
     * @return bool on error
     * 
     * @note loads the backend sequence with all appropriate mandatory features
     * @note using add_action hook for wordpress registry
     * 
    */
    private function _loadAdmin(){ 
        add_action('admin_menu', array(&$this,'load_admin_pages'));
    }
    
    /**
     * FrontEnd Loader
     * 
     * @param none none
     * @return bool on error
     * 
     * @note loads frontend sequence with all appropriate features
     * @todo MVC
     * @state INOP
     * 
    */
    private function _loadFrontEnd(){ 
        
        
        
    }
  
   /**
     * WordPress Databse Conduit Definition
     * 
     * @author MagoR
     * 
     * @param none none
     * @return bool on error
     * 
     * @note defines majic variables for $wpdb global
     * @note and asks for appropriate table prefix
     * 
    */
    private function _defineTables(){ 
        global $wpdb;
        $wpdb->ef_leagues = $wpdb->prefix . 'ef_leagues';
	$wpdb->ef_signups = $wpdb->prefix . 'ef_signups';
	$wpdb->ef_matches = $wpdb->prefix . 'ef_matches';
	$wpdb->ef_objections = $wpdb->prefix . 'ef_objections';
        $wpdb->ef_metas = $wpdb->prefix . 'usermeta';
        $wpdb->ef_users = $wpdb->prefix . 'users';
    }
    
    
    /**
     * Introduce WPDB to class variable
     * 
     * @author MagoR
     * 
     * @param none none
     * @return bool on error
     * 
     * 
    */
    private function _registerWPDB(){ 
        global $wpdb;
        $this->wpdb = $wpdb;
    }
    
   /**
     * Method on Request 
     *
     * @param $arg array
     * @return method call
     * 
     * @note catches extra methods and parameters calls by URL
     * @note using $GET superglobal and calls the appropriate method
     * @note with an optional parameter
     *
    */
    private function _loadActionULR($arg){ 
        foreach ($arg as $key => $value){ 
            if($key == "m"){               
                    if($arg['v']){ 
                        $this->$value($arg['v']);
                    }else{ 
                        $this->$value();
                    }
                    return true;
            }
        }
    }

    /**
     * Create View
     * 
     * @param $arg string
     * @param $admin bool explicit override
     * 
     * @return string view/output
     * 
     * @note creates requested HTML output using the appropriate template
     * @note and forwards $view and $data class variables for outputting
     * @note capable to return module content
     * 
     * @done dynamic request determination (admin/frontend)
     * 
     * @state COMPLETE/CLOSED
     * 
    */
    private function _loadTemplate($arg,$admin = false,$module = false){ 
        $result = $this->view;
        $data = $this->data;
        $modules = $this->modules;
        if($module){ 
            ob_start();
            include dirname (__FILE__) . '/admin/'.$arg.'.php';
            $result = ob_get_clean();
            return $result;
        }
        if(is_admin() || $admin){
            require_once (dirname (__FILE__) . '/admin/'.$arg.'.php'); 
        }else{ 
            require_once (dirname (__FILE__) . '/frontend/'.$arg.'.php');
        }
    }

    /**
     * Array Cleaner 
     * 
     * Checks argument for array elements. 
     * 
     * @todo deprication due to uselessy
     * 
    */
    private function _arrayInput($arg){ 
        if(is_array($arg)){ 
            $this->remark = true;
            return $arg;
        }else{ 
            $this->remark = false;
            return $arg;
        } 
    }
    
    /**
     * TableIzer v1.2 
     * 
     * @author: MagoR
     * 
     * @param $arg array associative
     * @param $setup array numeric | string 
     * @param $link bool
     * @return string table body
     * 
     * @example $this->_tableIzer($data,array(array(1,3,4,5),array('Name', 'Stuff 1', 'Stuff 2')),false);
     * 
     * @note expects raw query results and number of columns to show
     * @note then generates table.body for HTML output
     * @note $link parameter accepts base URLs for edit link generation
     * @note place result between <table> tags!
     *
     * @done custom table.header generation
     * @todo full table generation
     * 
    */
    private function _tableIzer($arg,$setup,$link = false){     
        
        $cols = $setup[0];
        $heads = $setup[1];
        
        if($heads){
            $result .= '<thead><tr>';
            foreach ($heads as $value){ $result .= '<td>' . $value . '</td>'; }
            $result .= '</tr></thead>';
        }
        
        $result .= '<tbody>';
        
        foreach ($arg as $key => $value){ 
            $count = 0;
            $leap = 0;
            $result .= '<tr>';
            foreach ($value as $x => $y){ 
               foreach ($cols as $z){
                   if($count == 0){ 
                       $myid = $y;
                   }
                   if($count == $z){
                       if($leap == 0 && $link == true){
                        $url = admin_url($link);   
                        $result .= '<td><a href="'.$url.$myid.'">' . $y . '</a></td>';
                       }else{ 
                        $result .= '<td>' . $y . '</td>';  
                       }
                       $leap++;
                   }
               }
               $count++;
            } 
            $result .= '</tr>';
        }
        
        $result .= '</tbody>';
        
        return $result;
    }

    /**
     * Slugalizer v0.5
     * @author MagoR
     * 
     * @param $arg string
     * @return string english chars
     * 
     * @note converts replaces hungarian characters to english
     * @note and replaces whitespaces with dashes
     * 
     * @todo recognize more languages (e.g. ukrain)
     * @todo more intelligent replacement
     * 
    */
    private function _slugalizer($arg){ 
        $hun = explode(",","á,é,í,ö,ő,ó,ü,ű,ú,Á,É,Í,Ö,Ő,Ó,Ü,Ű,Ú");
        $eng = explode(",","a,e,i,o,o,o,u,u,u,A,E,I,O,O,O,U,U,U");
        $arg = str_replace($hun, $eng, $arg);
        $arg = str_replace(' ', '-', strtolower($arg));
        return $arg;
    }
    
    /**
     * Array Izer v1.0
     * @author MagoR
     * 
     * @param $arg array
     * @param $link string action URL
     * @param $button string custom button label
     * @return string for output
     * 
     * @note shows editable array
     * 
     * @todo optional comparism with another array
     * 
     * @state COMPLETE/OPEN
     * 
    */
    private function _arrayIzer($arg, $link = false, $button = false){ 
        
        if(!$button){ $button = 'Save'; }
        
        $result .= '<table width="200"><tbody>';
        
        foreach ($arg as $key => $value){          
                    $result .= '<tr><td><form action="" method="post"><input type="hidden" name="ID" value="'.$value['ID'].'"/>'.$value['user_nicename'].'</td><td><input type="submit" name="submit" class="button button-primary" value="'.$button.'"></form></td></tr>';
        }
        
        $result .= '</tbody></table>';
        
        return $result;
    }
    
    /**
     * Check State
     * 
     * @author MagoR
     * 
     * @param $arg array
     * @return bool
     * 
     * @note returns true if requested status found
     * @note by default checks requested state in among the leagues
     * @note if no search parameter provided or no item ID assigned returns FALSE
     * @note fully customizable state check
     * @example  input array('search' => 'registered', 'ID' => 1);
     * 
     * @state COMPLETE/CLOSED
     * 
    */
    private function _check_state(array $arg){ 
        if(!$arg['search'] || !$arg['ID']){ return false; }else{ $arg['ID'] = intval($arg['ID']); }
        $arg_default = array('return' => 'status','table' => $this->wpdb->ef_leagues ,'column' => 'status','search' => false, 'C_ID' => 'ID', 'ID' => false);
        $arg = array_merge($arg_default,$arg);
        $return = $arg['return'];
        $result = $this->wpdb->get_results("SELECT * FROM {$arg['table']} WHERE `{$arg['C_ID']}` = '{$arg['ID']}' AND `{$arg['return']}` = '{$arg['search']}'", ARRAY_A);
        
        if(isset($result[0][$arg['return']])){ 
            return true;
        }else{ 
            return false;
        } 
    }
        
    /**
     * Query User Meta Data
     * 
     * @author MagoR
     * 
     * @param $arg bool
     * @return array assoc
     * 
     * @note returns array of the requested or all user meta data from ef_metas databasetable
     * 
     * @todo further enhancement
     * 
    */
    function get_ef_meta($arg = false){ 
        global $wpdb;
        
        if(!$arg){ 
            $result = $wpdb->get_results("SELECT * FROM {$wpdb->ef_metas}",ARRAY_A);
            return $result;
        }else{ 
            $result = $wpdb->get_results("SELECT * FROM {$wpdb->ef_metas} WHERE user_id = $arg",ARRAY_A);
            return $result[0];
        }
        
    }
    
    /**
     * Show Module
     * 
     * @author MagoR
     * 
     * @param $arg array for _check_state method
     * @param $module string requested module
     * @return bool
     * 
     * @note for more options check out _check_state method documentation
     * @note to unconditionally include a module just omit providing $arg parameter
     * @note input array('search' => 'open', 'ID' => 1 );
     * 
     * @state COMPLETE/CLOSED
     * 
    */
    function show_module($module, $arg = false){ 
        if($arg){
            $check = $this->_check_state($arg);
        }else{ 
            $check = true;
        }
        if($check){
          return $this->_loadTemplate('modules/'.$module,true,true);
        }
    }

    /**
     * Query All Information of League or Leagues
     * 
     * @author MagoR
     * 
     * @param $arg array
     * @return array assoc
     * 
     * @note returns an array of all information of the requested league or if no argument provided all of the leagues  
     * 
     * @todo further enhancement and more options
     * 
    */
    function get_league($arg = false){ 
        global $wpdb;
        //$arg = $this->_arrayInput($arg); 
        if($arg){ 
            $result = $wpdb->get_results("SELECT * FROM {$wpdb->ef_leagues} WHERE id = $arg",ARRAY_A); 
            return $result[0];
        }else{ 
           return $wpdb->get_results("SELECT * FROM {$wpdb->ef_leagues}");
        }
    }
    
     /**
      * Query All Player Information on request
      * 
      * @author MagoR
      * 
      * @param $arg int
      * @return array assoc
      * 
      * @note returns basic information of any requested or all players
      * 
      * @todo finalization and further enhancement
      * @state COMPLETE/TEST FAILED
      * 
    */
    function get_player($arg = false){ 
        //global $wpdb;

        if($arg){ 
            $result = $this->wpdb->get_results("SELECT ID, user_nicename, display_name FROM {$this->wpdb->ef_users} WHERE ID = $arg",ARRAY_A); 
            return $result[0];
        }else{ 
           return $this->wpdb->get_results("SELECT ID, user_nicename, display_name FROM {$this->wpdb->ef_users}", ARRAY_A);
        }
   
    }
 
     /**
      * Query Match or Matches
      *
      * @author MagoR
      * 
      * @param $arg array
      * @return array assoc
      * 
      * @note queries all information of the requested or matches
      * 
      * @todo wpdb query
      * @todo return state
      * @todo more options for queries
      * 
      * @state INOP
      * 
    */
    function get_match($arg = false){ 
        $arg = $this->_arrayInput($arg);
    
        
    }
    
     /**
      * Save League
      * 
      * @author MagoR
      *
      * @param $arg array
      * @return bool
      * 
      * @note creates new database entry to record a new league using array input from $_POST superglobal
      * 
      * @todo further enhancements
      * 
    */
    function save_league($arg){ 
        global $wpdb;
        if(!$arg['leagueslug']){ 
            $arg['leagueslug'] = $this->_slugalizer($arg['leaguename']);
        }else{
            $arg['leagueslug'] = $this->_slugalizer($arg['leagueslug']);
        }
        $wpdb->insert($wpdb->ef_leagues, array(
                'name' => $arg['leaguename'],
                'slug' => $arg['leagueslug'],
                'type' => $arg['leaguetype'],
                'game' => $arg['game'],
                'start_date' => $arg['start'],
                'end_date' => $arg['end'],
                'players' => $arg['contestants'],
                'status' => $arg['status'],
                'rules' => $arg['rules'],
                'rewards' => $arg['rewards'],
                'signups' => 0,
                'platform' => $arg['platform'],
                'stage' => 'Registered'
                ));
    }
    
    /**
     * Update League
     * 
     * @author MagoR
     * 
     * @param $arg array
     * @return bool
     * 
     * @note updates the exisiting league record with all appropriate data provided via $_POST superglobal
     * 
     * @todo handle sign-ups
     * @todo handle players and matches
     * 
     * @state USABLE/INPROG
     * 
    */
    function update_league($arg){ 
        global $wpdb;
        $slug = $arg['leagueslug'];
        if(!$arg['leagueslug']){ 
            $arg['leagueslug'] = $this->_slugalizer($arg['leaguename']);
        }else{
            $arg['leagueslug'] = $this->_slugalizer($arg['leagueslug']);
        }
        $wpdb->update($wpdb->ef_leagues, array(
                'name' => $arg['leaguename'],
                'slug' => $arg['leagueslug'],
                'type' => $arg['leaguetype'],
                'game' => $arg['game'],
                'start_date' => $arg['start'],
                'end_date' => $arg['end'],
                'players' => $arg['contestants'],
                'status' => $arg['status'],
                'rules' => $arg['rules'],
                'rewards' => $arg['rewards'],
                'signups' => 0,
                'platform' => $arg['platform']
                ), array( 'slug' => $slug, 'name' => $arg['leaguename'] ));
    }
    
 
     /**
      * Save Match
      *
      * @author MagoR
      * 
      * @param $arg array
      * @return bool on error
      * 
      * @note creates new match using appropriate match table
      * 
      * @todo $wpdb queries
      * @todo analysis
      * 
      * @state INPROGRESS/INOP
      * 
      * 
    */
    function save_match($arg = false){ 
        $arg = $this->_arrayInput($arg);
    
        
    }
    
     /**
      * Sign Up for League
      *
      * @author MagoR
      * 
      * @param $arg array
      * @return bool on error
      * 
      * @note updates league record in appropriate table and creates sign_up record
      * 
      * @todo $wpdb queries, analysis
      * 
      * @state INPROGRESS/INOP
      * 
      * 
    */
    function sign_up($arg = false){ 
        $arg = $this->_arrayInput($arg);
    
        
    }
       
    /**
     * Admin Page Loader
     * 
     * @author MagoR 
     *
     * @param none none
     * @return bool on error
     * 
     * @note registers and loads admin pages to WordPress Backend menu
     * @note creates appropriate URLs to call backend methods
     * @note register and enqueue scripts and misc elements
     * 
     * @state COMPLETE/OPEN
     * 
     * 
    */
    function load_admin_pages(){ 
         add_menu_page(__('Online Leagues','ef-general'), __('Online Leagues','ef-general'), 'manage_options', 'ef-general-settings', array(&$this,'load_general_settings'), EF_URL.'/style/cup.png' );
         add_submenu_page('ef-general-settings', __('Create League','ef-general'), __('Create League','ef-general'), 'manage_options', 'create-league', array(&$this,'load_create_league'));   
         add_submenu_page('ef-general-settings', __('Manage League','ef-general'), __('Manage League','ef-general'), 'manage_options', 'manage-league', array(&$this,'load_leagues'));   
         add_submenu_page('ef-general-settings', __('Manage Matches','ef-general'), __('Manage Matches','ef-general'), 'manage_options', 'manage-matches', array(&$this,'load_matches'));
         add_submenu_page('ef-general-settings', __('Objections','ef-general'), __('Objections','ef-general'), 'manage_options', 'manage-objections', array(&$this,'load_objections'));
         add_action( 'admin_enqueue_scripts', array(&$this,'load_addons') );
    }
    
    /**
     * Load Add-Ons 
     * 
     * @author MagoR
     * 
     * @param none none
     * @return bool on error
     * 
     * @note registers and enqueue misc elements to WordPress
     * 
     * @state COMPLETE/OPEN
     * 
     * 
    */
    function load_addons(){ 
        wp_register_style( 'datatables_css', plugins_url( 'addons/datatable/css/jquery.dataTables.css', __FILE__ ), false, '1.0.0' );
        wp_register_style( 'ef_override_css', plugins_url( 'style/override.css', __FILE__ ), false, '1.0.0' );
        wp_enqueue_style( 'datatables_css' );
        wp_enqueue_style( 'ef_override_css' );
        wp_enqueue_script( 'datatables-core-script', plugins_url( 'addons/datatable/src/DataTables.js', __FILE__ ), array('jquery'));
        wp_enqueue_script( 'datatables-jquery-script', plugins_url( 'addons/datatable/js/jquery.dataTables.min.js', __FILE__ ), array('jquery'));
        wp_enqueue_script( 'ef-custom-admin-script', plugins_url( 'scripts/custom.js', __FILE__ ), array('jquery'));
    }
    
    /**
     * BackEnd: General Settings 
     * 
     * @author MagoR
     * 
     * @param none none
     * @return bool on error
     * 
     * @note loads welcome screen and general settings
     * 
     * @todo enqueue some basic settings
     * 
     * @state COMPLETE/OPEN
     * 
     * 
    */
    function load_general_settings(){ 
        $this->_loadTemplate('general_settings', true); 
    }
    
    /**
     * BackEnd: Manage Leagues 
     * 
     * @author MagoR
     * 
     * @param none none
     * @return bool true for extra method
     * @return bool on error with no extra method
     * 
     * @note loads manage leagues screen and queries all leagues from the database
     * 
     * @todo initiate separate $_POST handler
     * @todo split $_GET handler
     * 
     * @state INPROGRESS/OPEN
     * 
     * 
    */
    function load_leagues(){        
        if($this->_loadActionULR($_GET)){
            return true;
        }
        if($_POST){ 
            $this->update_league($_POST);
        }
        $this->view = $this->_tableIzer($this->get_league(),array(array(1,3,4,5,6,7,8,9),array('Name', 'Type', 'Platform', 'Game', 'Start', 'End', 'Players', 'Status')),'admin.php?page=manage-league&m=load_edit_league&v=');
        $this->_loadTemplate('leagues', true);
        
    }
    
    /**
     * BackEnd: Create League 
     * 
     * @author MagoR
     * 
     * @param none none
     * @return bool true on post
     * @return bool on error
     * 
     * @note show form to create new league from backend
     * @note upon save loads manage league view
     * 
     * @todo spearate $_POST handler
     * @todo dynamic form elements
     * 
     * @state COMPLETE/OPEN
     * 
     * 
    */
    function load_create_league(){ 
        if($_POST){ 
            $this->save_league($_POST);
            $this->load_leagues();
            return true;
        }
        $this->_loadTemplate('create_league', true); 
    }
    
    /**
     * BackEnd: Edit League
     * 
     * @author MagoR
     * 
     * @param none none
     * @return bool on error
     * 
     * @note queries requested league by URL id ($_GET['v'])
     * @note renders edit league form
     * 
     * @todo dynamic form fields
     * @todo check for $_POST handling
     * 
     * @state COMPLETE/OPEN
     * 
     * 
    */
    function load_edit_league($arg = false){ 
        $this->view = $this->get_league($arg);
        $this->_loadTemplate('edit_league', true); 
    }  
    
    /**
     * BackEnd: Manage League Progress 
     * 
     * @author MagoR
     * 
     * @param $arg int
     * @return bool on error
     * 
     * @note renders league information page
     * @note queries users and matches
     * @note handle signups
     * @note handle match making/launching/pausing sequences
     * @note generally makes all necessary calculation required to start any registered league in the system
     * 
     * @todo get all potential players from database
     * @todo query sign ups / update sign ups
     * @todo query all matches
     * @todo calculate matches
     * @todo handle league types modulary (8/16/32/64/128 K/O) 
     * @todo handle WILDCARDS using separate methods
     * 
     * @state INCOMPLETE/INOP
     * 
     * 
    */
    function load_manage_league_progress($arg = false){ 
        $this->data['users'] = $this->_arrayIzer($this->get_player(),false,'Add');
        $this->view = $this->get_league($arg);
        $this->modules = $this->show_module('add_players',array('search' => 'OPEN', 'ID' => $arg));
        $this->_loadTemplate('manage_league_progress', true); 
    }
    
    /**
     * BackEnd: Manage Matches
     * 
     * @author MagoR
     * 
     * @param none none
     * @return bool on error
     * 
     * @note shows all registered matches in the system with an option to edit them
     * 
     * @todo query matches with an option to modify them
     * @todo handle $_POST and $_GET superglobals remotely
     * @todo create additional methods for editing
     * 
     * @state INCOMPLETE/INOP
     * 
     * 
    */
    function load_matches(){ 
        $this->_loadTemplate('matches', true); 
    }    
    
    /**
     * BackEnd: Manage Objections
     * 
     * @author MagoR
     * 
     * @param none none
     * @return bool on error
     * 
     * @note queries all objections registered in the system with an option for edit
     * 
     * @todo query objections using dynamic tables
     * @todo edit objections as tickets using remote methods
     * @todo handle $_POST and $_GET superglobals remotely
     * 
     * @state INCOMPLETE/INOP
     * 
     * 
    */
    function load_objections(){ 
        $this->_loadTemplate('objections', true); 
    }  
    
}
// Run the Plugin
global $efLoader;
$efLoader = new EuroFIFALeagueLoader();