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
    $arrSidebar = [
      [
        'header' => '',
        'itens' => [
          [
            'routeName' => 'default',
            'title' => 'Painel',
            'icon-left' => 'nav-icon fas fa-tachometer-alt',
            'icon-right' => ''
          ],
          [
            'routeName' => 'default',
            'title' => 'Widgets',
            'icon-left' => 'nav-icon fa fa-th',
            'icon-right' => $this->iconRightSidebar('span','right badge badge-danger','New')
          ],
          [
            'routeName' => '',
            'title' => 'Charts',
            'icon-left' => 'nav-icon fas fa-chart-pie',
            'icon-right' => $this->iconRightSidebar(),
            'children' => [
              [
                'routeName' => 'default',
                'title' => 'ChartJs',
                'icon-left' => 'far fa-circle nav-icon',
              ]
            ]
          ]
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
