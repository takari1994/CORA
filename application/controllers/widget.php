<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed!');

class Widget extends TCP_Controller {
    
    protected $wid_dir = 'pages/dashboard/widgets/';
    
    public function add() {
        $this->check_authority();
        
        if(isset($_POST['wid_id']) AND isset($_POST['parent'])) {
            $wid_id = $_POST['wid_id'];
            $area = $_POST['parent'];
            
            $this->load->model('mwidget');
            $this->load->model('msettings');
            
            $gen_settings = $this->msettings->get_set_gen();
            $wid_areas =    get_layout_wid_areas($gen_settings[0]->theme);
            $area_wids =    get_widgets($area);
            $wid_list =     $this->mwidget->get_widget_list();
            
            if(null != $this->mwidget->get_widget_list($wid_id) AND in_array_r($area,$wid_areas)) {
                $wid_info = $this->mwidget->get_widget_list($wid_id);
                $title =    $wid_info[0]->desc;
                $xtbl =     $wid_info[0]->child_tbl;
                $pos =      count($area_wids)+1;
                
                $add = $this->mwidget->add_widget($wid_id,$title,$area,$pos,$xtbl);
                
                if(true == $add) {
                    $data['wid_list'] = $this->mwidget->get_widget_list();
                    $data['wid_area_wids'] = get_widgets($area);
                    $this->load->view($this->wid_dir.'widgets_list',$data);
                }
            }
        }
    }
    
    public function wid_sett() {
        $this->check_authority();
        
        if(isset($_POST['wuid'])) {
            $this->load->model('mwidget');
            
            $wuid =       $_POST['wuid'];
            $wuid_info =  $this->mwidget->get_wid_used($wuid);
            
            if(null != $wuid_info) {
                $data['wu'] =   $wuid_info;
                $wid_info =     $this->mwidget->get_widget_list($wuid_info[0]->wid_id);
                $page =         $wid_info[0]->page;
                
                if(null != $wid_info[0]->child_tbl) {
                    $xtbl =           $wid_info[0]->child_tbl;
                    $wuid_xtra_info = $this->mwidget->get_wid_used_info($xtbl,$wuid);
                    $data['wu_info'] = $wuid_xtra_info;
                }
                
                $this->load->view($this->wid_dir.$page,$data);
            }
        }
    }
    
    public function update_wid_sett() {
        $this->check_authority();
        
        if(isset($_POST['wuid']) AND isset($_POST['title'])) {
            $this->load->model('mwidget');
            
            $wuid =       $_POST['wuid'];
            $title =      $_POST['title'];
            $wuid_info =  $this->mwidget->get_wid_used($wuid);
            
            if(null != $wuid_info) {
                $wid_info = $this->mwidget->get_widget_list($wuid_info[0]->wid_id);
                $page =     $wid_info[0]->page;
                
                if(null != $wid_info[0]->child_tbl) {
                    $xtbl = $wid_info[0]->child_tbl;
                    $xdata = $_POST['data'];
                } else {
                    $xtbl = null;
                    $xdata = null;
                }
                
                $update = $this->mwidget->update_widget($wuid,$title,$xtbl,$xdata);
                
                $data['wu'] = $this->mwidget->get_wid_used($wuid);
                if(null != $wid_info[0]->child_tbl) {
                    $xtbl =           $wid_info[0]->child_tbl;
                    $wuid_xtra_info = $this->mwidget->get_wid_used_info($xtbl,$wuid);
                    $data['wu_info'] = $wuid_xtra_info;
                }
                
                $this->load->view($this->wid_dir.$page,$data);
            }
        }
    }
    
    public function switch_pos() {
        $this->check_authority();
        
        $parent =  $_POST['parent'];
        $old_pos = $_POST['old_pos'];
        
        if(1 == $_POST['move'])
            $new_pos = $old_pos + 1;
        else if(0 == $_POST['move'])
            $new_pos = $old_pos - 1;
            
        $this->load->model('mwidget');
        $switch = $this->mwidget->switch_widget_pos($parent,$old_pos,$new_pos);
        
        if($switch) {
            $data['wid_list'] =      $this->mwidget->get_widget_list();
            $data['wid_area_wids'] = get_widgets($parent);
            $this->load->view($this->wid_dir.'widgets_list',$data);
        }
    }
    
    public function delete() {
        $this->check_authority();
        
        if(isset($_POST['wuid']) AND isset($_POST['parent'])) {
            $this->load->model('mwidget');
            
            $wuid =         $_POST['wuid'];
            $parent =       $_POST['parent'];
            $wuid_info =    $this->mwidget->get_wid_used($wuid);
            
            if(null != $wuid_info) {
                $wid_info = $this->mwidget->get_widget_list($wuid_info[0]->wid_id);
                
                if(null != $wid_info[0]->child_tbl)
                    $xtbl = $wid_info[0]->child_tbl;
                else
                    $xtbl = null;
                    
                $delete = $this->mwidget->delete_widget($wuid,$xtbl);
                
                if(true == $delete) {
                    $sort = $this->mwidget->sort_widgets($parent);
                    $data['wid_list'] =      $this->mwidget->get_widget_list();
                    $data['wid_area_wids'] = get_widgets($parent);
                    $this->load->view($this->wid_dir.'widgets_list',$data);
                }
            }
        }
    }
}