<?php

namespace Drupal\live_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LiveLocationSettingsForm.
 *
 * @package Drupal\live_location\Form
 */
class LiveLocationSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['live_location.location.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'live_location_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Set Config for live location form to store value in config.
    $config = $this->config('live_location.location.settings');

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#description' => $this->t('Enter Country Name'),
      '#required' => TRUE,
      '#default_value' => $config->get('country'),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#description' => $this->t('Enter City Name'),
      '#required' => TRUE,
      '#default_value' => $config->get('city'),
    ];

    // Timezone select values.
    $timezones = [
      '' => $this->t('Select Timezone'),
      'America/Chicago' => $this->t('America/Chicago'),
      'America/New_York' => $this->t('America/New_York'),
      'Asia/Tokyo' => $this->t('Asia/Tokyo'),
      'Asia/Dubai' => $this->t('Asia/Dubai'),
      'Asia/Kolkata' => $this->t('Asia/Kolkata'),
      'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
      'Europe/Oslo' => $this->t('Europe/Oslo'),
      'Europe/London' => $this->t('Europe/London'),
    ];

    $form['timezone'] = [
      '#title' => $this->t('Timezone'),
      '#type' => 'select',
      '#description' => "Select Timezone.",
      '#options' => $timezones,
      '#required' => TRUE,
      '#default_value' => $config->get('timezone'),
    ];

    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $country = $form_state->getValue('country');
    $city = $form_state->getValue('city');
    $timezone = $form_state->getValue('timezone');

    parent::submitForm($form, $form_state);

    // Set values into the live location config.
    $this->config('live_location.location.settings')
      ->set('country', $country)
      ->set('city', $city)
      ->set('timezone', $timezone)
      ->save();

  }

}
