<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class Menu_Principal_Controller extends Controller
{
    public function MenuPrincipal(){

          $url = "json/Menu.json";
          $string = file_get_contents($url);
          $array = json_decode($string, true);

          $Menu = '<ul class="main-navigation-menu">';

          foreach ($array as  $Principal) {
            $Submenu = $Principal;
            $Menu.= '<li>
                        <a href="javascript:void(0)">
                          <div class="item-content">
                            <div class="item-media">
                              <div class="lettericon" data-color="auto" data-text="'.$Submenu['Menu'].'" data-size="sm" data-char-count="2"></div>
                            </div>
                            <div class="item-inner">
                              <span class="title">'.$Submenu['Menu'].' </span><i class="icon-arrow"></i>
                            </div>
                          </div>
                        </a>';

                        foreach ($Submenu['nodes'] as  $value) {
                          $Nodos = $value;
                          $Menu.= '<ul class="sub-menu">';

                            foreach ($Nodos as $Nodo=>$Elemento) {
                                $Valores = explode('|',$Elemento);
                                $Menu.= '<li><a href="'.$Valores[1].'"><span class="title">'.$Valores[0].'</span></a></li>';
                            }

                          $Menu.= '</ul>';

                        }

            $Menu.= '</li>';
          }
          $Menu.='</ul>';

          return $Menu;

    }

  /*===================================================*/

  public function index(){
    //$ClaseMenu = new Menu_Principal_Controller;
     $MenuPrincipal = self::MenuPrincipal();
     return view('Menu',compact('MenuPrincipal'));
  }

}
