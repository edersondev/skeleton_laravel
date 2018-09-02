<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Collective\Html\FormFacade as Form;

class FormServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    Form::component('bsText', 'components.form.text', ['name', 'label', 'value', 'helpText', 'attributes']);
    Form::component('bsSelect', 'components.form.select', ['name', 'label', 'arrOptions', 'value','helpText', 'attributes']);
    Form::component('bsCheckbox', 'components.form.checkbox', ['name', 'label', 'value', 'checked','attributes']);
    Form::component('bsTitaCheckbox', 'components.form.titacheckbox', ['name', 'label', 'value', 'checked','attributes']);
    Form::component('bsTextArea', 'components.form.textarea', ['name', 'label', 'value','helpText', 'attributes']);
    Form::component('bsInputGroup', 'components.form.inputgroup', ['name', 'label', 'value','helpText', 'attributes', 'addon']);
    Form::component('bsFile', 'components.form.file', ['name', 'label','helpText', 'attributes']);
    Form::component('bsEmail','components.form.email', ['name','label','value', 'helpText','attributes']);
    Form::component('bsPassword','components.form.password',['name','label','helpText','attributes']);
    Form::component('bsRadio','components.form.radio',['name','label','arrOptions','value','attributes']);
    Form::component('bsDatepicker','components.form.datepicker',['name','label','value','attributes']);
    Form::component('bsNumber', 'components.form.number', ['name', 'label', 'value', 'attributes']);
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
