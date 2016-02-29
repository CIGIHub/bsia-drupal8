<?php
/**
 * @file
 * Contains \Drupal\bsia_connect\Form\BSIAConnectSubmissionForm.
 */

namespace Drupal\bsia_connect\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * BSIA Connect with us form.
 */
class BSIAConnectSubmissionForm extends FormBase {

	/**
	 * {@inheritdoc}
	 */
	public function getFormID() {
		return 'bsia_connect_form';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getEditableConfigNames() {
		return ['bsia_connect.settings'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$config = $this->config('bsia_connect.settings');

		$form['bsia_connect_title'] = array(
			'#type' => 'item',
			'#markup' => "<h1>How would you like to connect with us? (Select all that apply)</h1>",
		);

		$form['actions']['#type'] = 'actions';
		$form['actions']['submit'] = array(
			'#type' => 'submit',
			'#value' => $this->t('Sign Up'),
			'#button_type' => 'primary',
			'#prefix' => '<div class="submit-wrapper">',
			'#suffix' => '</div>',
		);

		// By default, render the form using theme_system_config_form().
		$form['#theme'] = 'system_config_form';

		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$logger = \Drupal::logger('bsia_connect');
		//$logger->notice("rate calculated");

		drupal_set_message(t("Submitted form"), 'status', FALSE);
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {

	}

	public function book_reservation_submit(array &$form, FormStateInterface $form_state) {
		$logger = \Drupal::logger('bsia_connect');
		$logger->notice("Redirecting user to reservation site.");

		$form_state->setRebuild(true);

		//Need to use TrustedRedirectResponse, otherwise Drupal screams at us.
		//$form_state->setResponse(new TrustedRedirectResponse('http://reservation.park2go.ca/reservation.php?depart=' . $depart . '&return=' . $arrival));

	}

}
