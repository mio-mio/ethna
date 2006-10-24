<?php
// vim: foldmethod=marker
/**
 *  Ethna_Plugin_Generator_View.php
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id$
 */

// {{{ Ethna_Plugin_Generator_View
/**
 *  ������ȥ��������饹
 *
 *  @author     Masaki Fujimoto <fujimoto@php.net>
 *  @access     public
 *  @package    Ethna
 */
class Ethna_Plugin_Generator_View extends Ethna_Plugin_Generator
{
    /**
     *  �ӥ塼�Υ�����ȥ����������
     *
     *  @access public
     *  @param  string  $forward_name   ���������̾
     *  @param  string  $app_dir        �ץ��������ȥǥ��쥯�ȥ�
     *  @return bool    true:���� false:����
     */
    function generate($forward_name, $app_dir)
    {
        // get application controller
        $c =& Ethna_Handle::getAppController($app_dir);
        if (Ethna::isError($c)) {
            return $c;
        }

        $view_dir = $c->getViewdir();
        $view_class = $c->getDefaultViewClass($forward_name, false);
        $view_path = $c->getDefaultViewPath($forward_name, false);

        $macro = array();
        $macro['project_id'] = $c->getAppId();
        $macro['forward_name'] = $forward_name;
        $macro['view_class'] = $view_class;
        $macro['view_path'] = $view_path;

        $user_macro = $this->_getUserMacro();
        $macro = array_merge($macro, $user_macro);

        Ethna_Util::mkdir(dirname("$view_dir/$view_path"), 0755);

        if (file_exists("$view_dir$view_path")) {
            printf("file [%s] already exists -> skip\n", "$view_dir$view_path");
        } else if ($this->_generateFile("skel.view.php", "$view_dir$view_path", $macro) == false) {
            printf("[warning] file creation failed [%s]\n", "$view_dir$view_path");
        } else {
            printf("view script(s) successfully created [%s]\n", "$view_dir$view_path");
        }
    }
}
// }}}
?>