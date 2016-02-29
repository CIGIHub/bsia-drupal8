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
			'#markup' => "<h2>How would you like to connect with us? (Select all that apply)</h2>",
		);

		$form['programs'] = array(
			'#type' => 'checkboxes',
			'#options' => array(
				"phd" => t('PhD in Global Governance'),
				"magg" => t('Master of Arts in Global Governance (MAGG)'),
				"mipp" => t('Master of International Public Policy (MIPP)'),
			),
			'#title' => $this->t('Find out more about our programs?'),
		);

		$form['weekly_bulletin'] = array(
			'#type' => 'checkbox',
			'#title' => $this->t('Sign up for our weekly bulletin to learn about upcoming events and opportunities.'),
		);

		$form['campus_tour'] = array(
			'#type' => 'checkbox',
			'#title' => $this->t('Book a tour of our campus.'),
		);

		$form['contact_title'] = array(
			'#type' => 'item',
			'#markup' => "Please provide us with your email address and name so we can connect with you.",
		);

		$form['first_name'] = array(
			'#type' => 'textfield',
			'#title' => t('First Name'),
			'#placeholder' => t("First Name"),
			'#size' => 60,
			'#maxlength' => 128,
		);

		$form['last_name'] = array(
			'#type' => 'textfield',
			'#title' => t('Last Name'),
			'#placeholder' => t("Last Name"),
			'#size' => 60,
			'#maxlength' => 128,
		);

		$form['email'] = array(
			'#type' => 'email',
			'#title' => t('Email'),
			'#placeholder' => t("Email Address (Required)"),
			'#size' => 60,
			'#maxlength' => 128,
			'#required' => true,
		);

		$form['actions']['#type'] = 'actions';
		$form['actions']['submit'] = array(
			'#type' => 'submit',
			'#value' => $this->t('Sign Up'),
			'#button_type' => 'primary',
			'#prefix' => '<div class="submit-wrapper">',
			'#suffix' => '</div>',
		);

		return $form;
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {

		drupal_set_message(t("Submitted form"), 'status', FALSE);
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {
		$programs = $form_state->getValue('programs');
		$weekly_bulletin = $form_state->getValue('weekly_bulletin');
		$campus_tour = $form_state->getValue('campus_tour');

		//$logger = \Drupal::logger('bsia_connect');
		//$logger->notice(print_r($programs, true));

		$optionSelected = false;
		//programs are checkboxes, either a 0 or the key.
		foreach ($programs as $key => $value) {
			if (!empty($value)) {
				$optionSelected = true;
				break;
			}
		}

		if (!$optionSelected && empty($weekly_bulletin) && empty($campus_tour)) {
			$form_state->setErrorByName('bsia_connect_title', $this->t("You must select at least one option!"));
		}
	}
}
