<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Route;

class SidebarServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    $subItemChart = [
      $this->buildItemMenu('roles.index','ChartJs','far fa-circle nav-icon')
    ];
    $arrSidebar = [
      [
        'header' => '',
        'itens' => [
          $this->buildItemMenu('default','Painel','nav-icon fas fa-tachometer-alt'),
          $this->buildItemMenu('default','Widgets','nav-icon fa fa-th', $this->iconRightSidebar('span','right badge badge-danger','New')),
          $this->buildItemMenu('users.index','Usuários','nav-icon fa fa-users'),
          $this->buildItemMenu('default','Charts','nav-icon fas fa-chart-pie',$this->iconRightSidebar(),$subItemChart),
        ],
        
      ],
      
    ];
    //dd($arrSidebar);
    view()->share('arrSidebar', $arrSidebar);
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

  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }
}
