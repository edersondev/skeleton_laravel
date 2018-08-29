<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class SidebarComposer
{
  public function compose(View $view)
  {
    $view->with('arrSidebar', $this->buildMenu());
  }

  public function buildMenu()
  {
    $subItemChart = [
      $this->buildItemMenu('permissoes.index','ChartJs','far fa-circle nav-icon')
    ];
    $arrSidebar = [
      [
        'header' => '',
        'itens' => [
          $this->buildItemMenu('default','Painel','nav-icon fas fa-tachometer-alt'),
          // $this->buildItemMenu('default','Widgets','nav-icon fa fa-th', $this->iconRightSidebar('span','right badge badge-danger','New')),
          // $this->buildItemMenu('usuarios.index','Usuários','nav-icon fa fa-users'),
          //$this->buildItemMenu('default','Charts','nav-icon fas fa-chart-pie',$this->iconRightSidebar(),$subItemChart),
        ],
        
      ],
    ];

    if( auth()->user()->hasRole('Administrador') ) {
      $arrSidebar[0]['itens'][] = $this->buildItemMenu('usuarios.index','Usuários','nav-icon fa fa-users');
      $subItemSeguranca = [
        $this->buildItemMenu('perfis.index','Perfis','far fa-circle nav-icon'),
        $this->buildItemMenu('permissoes.index','Permissões','far fa-circle nav-icon')
      ];
      $arrSidebar[0]['itens'][] = $this->buildItemMenu('','Segurança','nav-icon fas fa-user-lock',$this->iconRightSidebar(),$subItemSeguranca);
    }
    
    return $arrSidebar;
  }

  /**
   * 
   */
  public function iconRightSidebar($tag='i',$class='right fa fa-angle-left',$text='')
  {
    return [
      'tag' => $tag,
      'class' => $class,
      'text' => $text
    ];
  }

  public function buildItemMenu($routeName, $title, $icon_left = '', $icon_right = '', $children = null)
  {
    $item = [
      'routeName' => $routeName,
      'title' => $title,
      'icon-left' => $icon_left,
      'icon-right' => $icon_right
    ];

    if(!is_null($children)){
      $item['children'] = $children;
    }

    return $item;
  }
}